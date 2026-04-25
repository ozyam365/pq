<?php
// 줄바꿈 (CLI / WEB 자동 대응)
if (!function_exists('nl')) {
    function nl() {
        return (php_sapi_name() === 'cli') ? PHP_EOL : "<br>";
    }
}

// 안전 출력 (HTML)
if (!function_exists('e')) {
    function e($str) {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }
}

// 디버그 출력
if (!function_exists('dd')) {
    function dd($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit;
    }
}

// 값 존재 체크 (null / 빈 문자열 방지)
if (!function_exists('val')) {
    function val($v, $default = '') {
        return isset($v) && $v !== '' ? $v : $default;
    }
}

// 문자열 포함 여부
if (!function_exists('str_contains_safe')) {
    function str_contains_safe($haystack, $needle) {
        return strpos($haystack, $needle) !== false;
    }
}

// 배열 안전 접근
if (!function_exists('arr_get')) {
    function arr_get($arr, $key, $default = null) {
        return isset($arr[$key]) ? $arr[$key] : $default;
    }
}

// 간단 로그 (파일)
if (!function_exists('log_write')) {
    function log_write($msg, $file = 'pq.log') {
        $line = "[" . date('Y-m-d H:i:s') . "] " . $msg . PHP_EOL;
        file_put_contents($file, $line, FILE_APPEND);
    }
}
?>