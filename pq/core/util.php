<?php
// pq/core/util.php

/**
 * 1. [기능 통합] 파일 및 메뉴 수사
 */
function pq_scan_menu($dir = 'sample') {
    $menu = [];
    $base_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $dir;
    if (is_dir($base_path)) {
        $items = array_diff(scandir($base_path), array('.', '..'));
        foreach ($items as $item) {
            if (is_dir($base_path . '/' . $item)) {
                $menu[] = [
                    'id'    => $item,
                    'name'  => strtoupper($item),
                    'link'  => "/$item/index"
                ];
            }
        }
    }
    return $menu;
}

function pq_get_menu() {
    @include $_SERVER['DOCUMENT_ROOT'] . "/set/cfg_menu.php";
    return $_MENU_LIST ?? [];
}

/**
 * 2. [가공 엔진] FilterFlow & StrFlow 체이닝
 * 로드맵 v0.7의 핵심인 가공 로직을 체인 문법에 최적화
 */
class FilterFlow {
    private $target;
    private $range;

    public function filter($range) {
        $this->range = str_replace(['~', ' '], ['-', ''], $range);
        return $this;
    }

    public function on($input) {
        $this->target = (string)$input;
        return $this;
    }

    public function replace($replacement = '') {
        if (!$this->range) return $this->target;
        // u 플래그로 한글 등 멀티바이트 대응 및 정규식 안정화
        $pattern = "/[^" . preg_quote(str_replace(',', '', $this->range), '/') . "]/u";
        return preg_replace($pattern, $replacement, $this->target);
    }
}

// 숏컷 함수: [[ filter("0~9").on(@data).replace() ]] 형태 지원
function filter($range) { return (new FilterFlow())->filter($range); }

/**
 * 3. [실무 가공] StrFlow 체이닝 전용 함수들
 */
function pq_money($val) { return number_format((int)$val); }

function pq_hancut($val, $len) {
    if (mb_strwidth($val, 'UTF-8') <= $len) return $val;
    return mb_strimwidth($val, 0, $len, '..', 'UTF-8');
}

function pq_clean($val) {
    if (is_array($val)) return array_map('pq_clean', $val);
    return htmlspecialchars(strip_tags((string)$val), ENT_QUOTES, 'UTF-8');
}

// 로드맵 v0.7 확장: 전화번호 마스킹 등 실무 함수 추가 가능성 확보
function pq_phone($val) {
    return preg_replace("/(^02.{0,2}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/", "$1-****-$3", $val);
}

/**
 * 4. [시스템 예약어] 15대 예약어 핵심 로직
 */
class PQDate {
    public function __get($key) {
        return match($key) {
            'now' => date("Y-m-d"),
            'full' => date("Y-m-d H:i:s"),
            'year' => date("Y"),
            default => date("Y-m-d H:i:s")
        };
    }
}
function date_pq() { static $i; if (!$i) $i = new PQDate(); return $i; }

class PQTime {
    public function __get($key) {
        return match($key) {
            'stamp' => time(),
            'hi' => date("H:i"),
            default => date("H:i:s")
        };
    }
}
function time_pq() { static $i; if (!$i) $i = new PQTime(); return $i; }

// [보안 강화] form.safe() 및 required() 기반 마련
class PQForm {
    public function __get($key) {
        $val = $_REQUEST[$key] ?? null;
        return ($val !== null) ? pq_clean($val) : null;
    }
    
    // 로드맵 v0.7: 필수값 체크
    public function required($keys) {
        $keys = is_array($keys) ? $keys : explode(',', $keys);
        foreach ($keys as $k) {
            if (empty($_REQUEST[trim($k)])) {
                die("❌ [PQ_AUTH_ERR] 필수 입력값이 누락되었습니다: " . $k);
            }
        }
        return $this;
    }

    public function all() { return array_map('pq_clean', $_REQUEST); }
}
function form_pq() { static $i; if (!$i) $i = new PQForm(); return $i; }

/**
 * 5. [데이터 수사] v0.7~v0.9 확장용 (import 기능 통합)
 */
if (!function_exists('pq_data')) {
    function pq_data($d) { return $d; }
}

// import 시 파일 존재 여부 및 경로를 검증하는 내부 유틸
function pq_import_path($path) {
    $path = trim(str_replace(['"', "'", ';'], '', $path));
    $full_path = $_SERVER['DOCUMENT_ROOT'] . "/html/" . $path;
    
    if (file_exists($full_path . ".pq")) return $full_path . ".pq";
    if (file_exists($full_path . ".php")) return $full_path . ".php";
    if (file_exists($full_path)) return $full_path;
    
    return false;
}
/**
 * 6. [가공 수사관] PQ_Util
 * @aaa.hancut(10) 등의 문법을 실질적으로 처리하는 엔진
 */
class PQ_Util {
    private $val;

    public function __construct($value) {
        $this->val = $value;
    }

    // 한글 자르기 체이닝
    public function hancut($len) {
        $this->val = pq_hancut($this->val, $len);
        return $this;
    }

    // 돈 표기 체이닝
    public function money() {
        $this->val = pq_money($this->val);
        return $this;
    }

    // 전화번호 마스킹 체이닝
    public function phone() {
        $this->val = pq_phone($this->val);
        return $this;
    }

    // 최종 출력 (echo 시 자동으로 실행)
    public function __toString() {
        return (string)$this->val;
    }
}

?>