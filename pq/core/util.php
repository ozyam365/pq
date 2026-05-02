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
    include $_SERVER['DOCUMENT_ROOT'] . "/set/cfg_menu.php";
    return $_MENU_LIST ?? [];
}

// 2. [신규 수사] 인간의 언어로 하는 정규식 엔진
class FilterFlow {
    private $target;
    private $range;

    public function filter($range) {
        // "0~9" -> "0-9", "가~힣" -> "가-힣" 변환 및 쉼표 정제
        $this->range = str_replace(['~', ' '], ['-', ''], $range);
        return $this;
    }

    public function on($input) {
        $this->target = (string)$input;
        return $this;
    }

    public function replace($replacement = '') {
        if (!$this->range) return $this->target;
        // 유니코드(u) 플래그로 한글 완벽 대응
        $pattern = "/[^" . str_replace(',', '', $this->range) . "]/u";
        return preg_replace($pattern, $replacement, $this->target);
    }
}

function filter($range) { return new FilterFlow($range); }

// 3. [신규 수사] StrFlow 실무 가공 함수들
// 팁: PHP의 기본 자료형에는 메서드를 붙일 수 없으므로, 
// ready.php에서 .money() 등을 처리할 때 이 함수들을 호출하도록 연결됩니다.

function pq_money($val) { return number_format((int)$val); }

function pq_hancut($val, $len) {
    if (mb_strwidth($val, 'UTF-8') <= $len) return $val;
    return mb_strimwidth($val, 0, $len, '..', 'UTF-8');
}

function pq_clean($val) {
    // [보안 수사 지침] 스크립트 태그를 무력화하는 핵심 장치
    return htmlspecialchars(strip_tags((string)$val), ENT_QUOTES, 'UTF-8');
}

function pq_date($val, $fmt = "Y-m-d") {
    $ts = is_numeric($val) ? $val : strtotime($val);
    return $ts ? date($fmt, $ts) : $val;
}

// 4. [데이터 수사] pq_data (v0.7 pluck, where 확장용 뼈대)
if (!function_exists('pq_data')) {
    function pq_data($d) {
        // 배열이나 객체를 PQ 전용 데이터 객체로 래핑하여 
        // .where().pluck() 체이닝을 지원할 준비를 합니다.
        return $d; 
    }
}
?>