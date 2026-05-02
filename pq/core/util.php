<?php
// pq/core/util.php

// 1. [기존 업무] 메뉴 수사 및 설정 로드
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

// 2. [신규 수사] 인간의 언어로 하는 정규식 엔진
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
        $pattern = "/[^" . str_replace(',', '', $this->range) . "]/u";
        return preg_replace($pattern, $replacement, $this->target);
    }
}

function filter($range) { return (new FilterFlow())->filter($range); }

// 3. [StrFlow 실무 가공 함수들]
function pq_money($val) { return number_format((int)$val); }

function pq_hancut($val, $len) {
    if (mb_strwidth($val, 'UTF-8') <= $len) return $val;
    return mb_strimwidth($val, 0, $len, '..', 'UTF-8');
}

function pq_clean($val) {
    return htmlspecialchars(strip_tags((string)$val), ENT_QUOTES, 'UTF-8');
}

function pq_date_format($val, $fmt = "Y-m-d") {
    $ts = is_numeric($val) ? $val : strtotime($val);
    return $ts ? date($fmt, $ts) : $val;
}

// 4. [시스템 예약어 수사관 결착] date, time, form
class PQDate {
    public function __get($key) {
        if ($key == 'now') return date("Y-m-d");
        if ($key == 'full') return date("Y-m-d H:i:s");
        if ($key == 'year') return date("Y");
        return date("Y-m-d H:i:s");
    }
}
function date_pq() { static $i; if (!$i) $i = new PQDate(); return $i; }

class PQTime {
    public function __get($key) {
        if ($key == 'stamp') return time();
        if ($key == 'hi') return date("H:i");
        return date("H:i:s");
    }
}
function time_pq() { static $i; if (!$i) $i = new PQTime(); return $i; }

class PQForm {
    public function __get($key) {
        // 모든 입력값(POST/GET)을 자동으로 세탁해서 반환
        $val = $_REQUEST[$key] ?? null;
        return ($val !== null) ? htmlspecialchars(strip_tags((string)$val), ENT_QUOTES, 'UTF-8') : null;
    }
    public function all() { return $_REQUEST; }
}
function form_pq() { static $i; if (!$i) $i = new PQForm(); return $i; }

// 5. [데이터 수사] pq_data (v0.7 pluck, where 확장용 뼈대)
if (!function_exists('pq_data')) {
    function pq_data($d) { return $d; }
}
?>