<?php
/**
 * PQ Utility Core (v0.9.0)
 * [수사 종결] 중복 클래스 완전 소탕 및 체이닝 유틸리티 강화
 * [철칙] 뷰 파일에서 출력 직전의 데이터를 아름답고 안전하게 가공한다.
 */

class PQ_Util {
    private $val;
    public function __construct($v) { $this->val = $v; }

    /**
     * 🕵️ 빈 값 수색
     */
    public function filled() { 
        return !empty(trim((string)$this->val)); 
    }

    /**
     * 🕵️ 형광펜 수사: 특정 단어 강조
     */
    public function mark($w) {
        if (empty($w) || empty($this->val)) return $this;
        $this->val = str_replace($w, "<mark class='bg-warning'>$w</mark>", $this->val);
        return $this;
    }

    /**
     * 🕵️ 색상 수사: 값이 일치할 경우 색상 부여
     */
    public function color($c, $match) {
        if ($this->val == $match) {
            $this->val = "<span style='color:$c; font-weight:bold;'>{$this->val}</span>";
        }
        return $this;
    }

    /**
     * 🕵️ 아이콘 수사: 부트스트랩 아이콘 결합
     */
    public function icon($type) {
        if (empty($this->val)) return $this;
        $cls = ($type == "image") ? "bi-image" : (($type == "file") ? "bi-file-earmark" : $type);
        $this->val .= " <i class='bi $cls text-primary'></i>";
        return $this;
    }

    /**
     * 🕵️ 화폐 수사: 천단위 콤마 찍기
     */
    public function money() { 
        if (is_numeric($this->val)) {
            $this->val = number_format((float)$this->val); 
        }
        return $this; 
    }

    /**
     * 🕵️ 한글 요약 수사: mb_strimwidth 활용
     */
    public function hancut($l) { 
        $this->val = mb_strimwidth((string)$this->val, 0, $l, '..', 'UTF-8'); 
        return $this; 
    }

    public function __toString() { return (string)$this->val; }
}

/**
 * 🕵️ 자동 수사망(Route) 확장 장비
 */
if (!function_exists('autoRoute')) {
    function autoRoute($dir, $prefix) {
        if (!is_dir($dir)) return;
        // .pq 파일뿐만 아니라 폴리스라인 준수를 위해 정렬 수사
        $items = glob($dir . '/*.pq');
        if (!$items) return;
        
        foreach ($items as $file) {
            $name = basename($file, '.pq');
            if (class_exists('PQRouter')) {
                // 루트(/) 경로와 접두사를 조합하여 수사망 등록
                $route_path = rtrim($prefix, '/') . '/' . $name;
                PQRouter::set($route_path, $file);
            }
        }
    }
}

/**
 * 유틸리티 헬퍼 함수
 * 사용법: [[= util(@price).money() ]]
 */
if (!function_exists('util')) {
    function util($v) { return new PQ_Util($v); }
}

/**
 * 🕵️ [범인 소탕 구역 기록]
 * 1. PQDate, date_pq -> core/date.php로 이양 완료
 * 2. PQForm, form_pq -> core/form.php로 이양 완료
 * 3. 중복된 깡통 클래스 선언부 영구 삭제됨
 */
?>
