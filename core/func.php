<?php
// 1. 전역 상태 관리 (StrFlow 방향)
global $PQ_STR_SORT;
$PQ_STR_SORT = $PQ_STR_SORT ?? "left";

// 2. [헌법 2조] StrFlow 가공 함수
if (!function_exists('pq_sort')) {
    function pq_sort($v, $dir) {
        global $PQ_STR_SORT;
        $PQ_STR_SORT = trim($dir, '"\' ');
        return $v;
    }
}

if (!function_exists('pq_hancut')) {
    function pq_hancut($v, $len) {
        global $PQ_STR_SORT;
        $v = (string)$v;
        
        // 1. 전체 폭 계산
        $total_w = mb_strwidth($v, 'UTF-8');
        if ($total_w <= $len) return $v;

        // 2. 점(..)을 뺀 실제 담을 폭
        $w = ($len > 2) ? $len - 2 : $len;

        if ($PQ_STR_SORT == "right") {
            // [오른쪽 기준] 
            // 앞에서부터 한 글자씩 빼면서 남은 폭이 $w 이하가 될 때까지 반복
            $res = $v;
            while (mb_strwidth($res, 'UTF-8') > $w) {
                $res = mb_substr($res, 1, null, 'UTF-8');
            }
            return ".." . $res;
        } else {
            // [왼쪽 기준] 
            // mb_strimwidth가 가끔 말썽이니 mb_substr로 안전하게 처리
            $res = "";
            for ($i = 0; $i < mb_strlen($v, 'UTF-8'); $i++) {
                $char = mb_substr($v, $i, 1, 'UTF-8');
                if (mb_strwidth($res . $char, 'UTF-8') > $w) break;
                $res .= $char;
            }
            return $res . "..";
        }
    }
}

// 3. [헌법 4조] 데이터 처리 유틸리티
if (!function_exists('pq_money')) {
	// core/func.php 수정
	function pq_money($v = null) { 
		// @ 가 붙거나 null이면 경고 없이 0으로 변환
		if ($v === null || $v === "") return "0"; 
		return is_numeric($v) ? number_format((float)$v) : $v; 
	}
}

if (!function_exists('pq_date')) {
    function pq_date($v = null, $fmt = "Y-m-d") { 
        if (!$v) return "";
        $time = is_numeric($v) ? (int)$v : strtotime($v);
        return $time ? date($fmt, $time) : ""; 
    }
}

if (!function_exists('pq_clean')) {
    function pq_clean($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
}

// 4. [헌법 4조] 배열 및 출력 도구
if (!function_exists('pq_map')) {
    function pq_map($arr, $fn) { return array_map($fn, (array)$arr); }
}

if (!function_exists('pq_filter')) {
    function pq_filter($arr, $fn) { return array_filter((array)$arr, $fn); }
}

if (!function_exists('pq_print')) {
    function pq_print($v) { 
        echo "<pre style='background:#f4f4f4; padding:10px; border:1px solid #ddd; border-radius:5px; font-family:monospace;'>"; 
        print_r($v); 
        echo "</pre>"; 
    }
}
?>