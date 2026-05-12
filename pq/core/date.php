<?php
/**
 * PQ Date Manager (v3.1.1)
 * [수사 종결] 중복 선언 방어막 강화 및 체이닝 편의성 극대화
 * [긴급 수사] db.php 내 PQDate 중복 선언 제거 필수 (현재 이 파일이 주권 점유)
 */

date_default_timezone_set("Asia/Seoul");

if (!class_exists('PQDate', false)) {
    class PQDate {
        private $dt;

        public function __construct($time = "now") { $this->reset($time); }
        
        public function reset($time) {
            try {
                if (is_numeric($time)) {
                    $this->dt = (new DateTime())->setTimestamp($time);
                } else {
                    $this->dt = new DateTime($time ?: "now");
                }
            } catch (Exception $e) { $this->dt = new DateTime(); }
            return $this;
        }

        // --- [핵심 타격: static 호출 및 체이닝 시발점] ---
        public static function now() { return (new self("now"))->format("Y-m-d H:i:s"); }
        public static function today() { return (new self("now"))->format("Y-m-d"); }
        public static function parse($time) { return new self($time); }
        
        /**
         * 🕵️ 말일 수사: (@date).lastDay() 또는 date.lastDay() 대응
         */
        public function lastDay($as_obj = false) { 
            $last = $this->dt->format("t");
            return $as_obj ? $this->reset($this->dt->format("Y-m-$last")) : $last; 
        }

        // --- [1. 대칭형 시간 여행 (완전 보존)] ---
        public function addYear($v = 1) { $this->dt->modify("+$v year"); return $this; }
        public function subYear($v = 1) { $this->dt->modify("-$v year"); return $this; }
        public function addMonth($v = 1) { $this->dt->modify("+$v month"); return $this; }
        public function subMonth($v = 1) { $this->dt->modify("-$v month"); return $this; }
        public function addDay($v = 1) { $this->dt->modify("+$v day"); return $this; }
        public function subDay($v = 1) { $this->dt->modify("-$v day"); return $this; }
        
        // --- [2. 퀵 리포트 및 정보 추출 (완전 보존)] ---
        public function format($f = "Y-m-d H:i:s") { return $this->dt->format($f); }
        public function timestamp() { return $this->dt->getTimestamp(); }
        public function isPast() { return $this->dt < new DateTime(); }

        /**
         * 인적 보고서: "방금 전", "5분 전" 등
         */
        public function humanize() {
            $diff = time() - $this->timestamp();
            if ($diff <= 0) return "방금 전";
            if ($diff < 60) return $diff . "초 전";
            if ($diff < 3600) return floor($diff / 60) . "분 전";
            if ($diff < 84600) return floor($diff / 3600) . "시간 전";
            return floor($diff / 86400) . "일 전";
        }

        public function __toString() { return $this->format(); }
    }
}

// 신분 보장 및 알리아스
if (!class_exists('DateMaker')) { class_alias('PQDate', 'DateMaker'); }

/**
 * 헬퍼 함수 (중복 방어)
 * 사용법: [[= @d = date.parse("2023-01-01"); ]]
 */
if (!function_exists('date_pq')) {
    function date_pq($time = "now") { return new PQDate($time); }
}
?>
