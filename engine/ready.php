<?php
function pq_ready($code) {
    if (empty(trim((string)$code))) return '';
    $current_path = $GLOBALS['full_path'] ?? $_SERVER['SCRIPT_FILENAME'];
    $strings = [];

    // 1. [보호] 따옴표 격리
    $code = preg_replace_callback('/(["\'])(?:(?=(\\\\?))\2.)*?\1/s', function($m) use (&$strings) {
        $key = '##STR' . count($strings) . '##';
        $strings[$key] = $m[0]; 
        return $key;
    }, $code);

    // 2. [함수] .money() 전역 함수 선제 래핑 (마침표 변환 전 실행)
    $code = preg_replace('/([\$@\w\->\(\)\[\]\.]+)\.money\(\)/', '[[FN_MONEY]]($1)', $code);

    // 3. [헌법] import 처리 (세미콜론 흡수 및 경로 보호)
    $code = preg_replace_callback('/import\s+(##STR\d+##)\s*;/', function($m) use ($current_path, $strings) {
        $target = isset($strings[$m[1]]) ? trim($strings[$m[1]], '"\'') : '';
        $base_dir = is_dir($current_path) ? $current_path : dirname($current_path);
        $final = realpath($base_dir . '/' . $target);
        if (!$final || is_dir($final)) return "";
        $safe_final = str_replace('.', '[[SAFE_DOT]]', $final);
        return "eval(pq_ready(file_get_contents(str_replace('[[SAFE_DOT]]', '.', '$safe_final'))));";
    }, $code);

    // 4. [래핑] 배열 래핑 토큰화 (괄호 짝 강제 고정)
    $code = preg_replace('/=\s*\[/s', '= pq_data([[OPEN]]', $code);
    $code = preg_replace('/\]\s*;/s', '[[CLOSE]]);', $code);

    // 5. [기호] 디버그 및 아이덴티티 치환 (@ -> $)
    $code = preg_replace('/debug\.on\(\)/', 'pq_debug("on")', $code);
    $code = preg_replace('/\((@\w+)\)\s*=/', '$1 =', $code);
    $code = preg_replace('/@([a-zA-Z_]\w*)/', '\$$1', $code);

    // 6. [전쟁] 남은 마침표만 화살표(->)로 변환
    $code = preg_replace('/\.([a-zA-Z_]\w*)/', '->$1', $code);

    // 7. [복구] 토큰 환원 및 특수 구문 원복
    $code = str_replace('[[FN_MONEY]]', 'pq_money', $code);
    $code = str_replace(['[[OPEN]]', '[[CLOSE]]'], ['[', ']'], $code);
    $code = str_replace('db->', 'db()->', $code);
    $code = preg_replace('/filter\((.*?)\)->on\((.*?)\)->replace\(\)/', 'filter_pq($1)->on($2)->replace()', $code);
    $code = preg_replace('/\bprint\s*\(/', 'pq_print(', $code);

    if (!empty($strings)) {
        foreach ($strings as $k => $v) $code = str_replace($k, $v, $code);
    }
    return $code;
}
?>