<?php
function pq_ready($code) {
    if (empty(trim((string)$code))) return '';
    global $full_path;
    $strings = [];

    // 1. [보호] 따옴표 내부 격리 ($m[0]으로 정확히 매칭)
    $code = preg_replace_callback('/(["\'])(?:(?=(\\\\?))\2.)*?\1/s', function($m) use (&$strings) {
        $key = '___PQSTR' . count($strings) . '___';
        $strings[$key] = $m[0]; 
        return $key;
    }, $code);

    // 2. [헌법 1조] import - $m[1]을 사용하여 TypeError 방지 및 경로 보호
    $code = preg_replace_callback('/import\s+(___PQSTR\d+___)\s*;/', function($m) use ($full_path, $strings) {
        $key = $m[1]; // 배열에서 키값 문자열만 추출
        $target = isset($strings[$key]) ? trim($strings[$key], '"\'') : '';
        
        // 마침표 오염 방지를 위해 아예 이 단계에서 마침표를 [[DOT]]으로 숨김
        $final = dirname($full_path) . '/' . $target;
        $final_safe = str_replace('.', '[[DOT]]', $final);
        
        return "eval(pq_ready(file_get_contents('$final_safe')));";
    }, $code);

    // 3. [아이덴티티] 객체 대입 및 접근 (@user) = / (@user).aa
    $code = preg_replace('/\((@\w+)\)\s*=/', '$1 =', $code);
    $code = preg_replace('/\((@\w+)\)\.([a-zA-Z_]\w*)/', '$1->$2', $code);

    // 4. [헌법 2조] StrFlow 가공 함수 래핑
    $code = preg_replace('/([\$@\w\->\(\)\.]+)\.money\(\)/', 'pq_money($1)', $code);
    $code = preg_replace('/([\$@\w\->\(\)\.]+)\.date\((.*?)\)/', 'pq_date($1, $2)', $code);
    $code = preg_replace('/([\$@\w\->\(\)\.]+)\.hancut\((\d+)\)/', 'pq_hancut($1, $2)', $code);

    // 5. [변환] 기본 문법 치환
    $code = preg_replace('/@([a-zA-Z_]\w*)/', '\$$1', $code);
    $code = preg_replace('/\bfn\s*\((.*?)\)\s*\{/', 'function($1) {', $code);
    $code = preg_replace('/\bprint\s*\(/', 'pq_print(', $code);
    $code = preg_replace('/\bdb\./', 'db()->', $code);

    // 6. [마무리] 나머지 일반 마침표 치환 (임시 키값 오염 방지)
    for($i=0; $i<3; $i++) {
        $code = preg_replace('/(?<!___PQSTR\d)(?<!___PQSTR\d\d)\.([a-zA-Z_]\w*)/', '->$1', $code);
    }

    // 7. [복원] 숨겼던 마침표와 문자열 최종 복구
    $code = str_replace('[[DOT]]', '.', $code);
    if (!empty($strings)) {
        foreach ($strings as $k => $v) $code = str_replace($k, $v, $code);
    }
    return $code;
}
?>