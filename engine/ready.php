<?php

function pq_preprocess($code) {

    // =========================================================
    // 🔥 0. 기본 정리
    // =========================================================
    $code = trim($code);

    // =========================================================
    // 🔥 1. 문자열 보호 (최상단)
    // =========================================================
    $strings = [];
    $code = preg_replace_callback('/"[^"]*"/u', function($m) use (&$strings) {
        $key = '__STR' . count($strings) . '__';
        $strings[$key] = $m[0];
        return $key;
    }, $code);

    // =========================================================
    // 🔥 2. @ → $
    // =========================================================
    $code = preg_replace('/@(\w+)/', '$\1', $code);

    // =========================================================
    // 🔥 3. 기본 함수
    // =========================================================
    $code = preg_replace('/\btrace\.on\s*\(\)/i', 'Trace::on()', $code);
    $code = preg_replace('/\btrace\.off\s*\(\)/i', 'Trace::off()', $code);
    $code = preg_replace('/\bmsg\.print\s*\(/i', 'Msg::print(', $code);

    // =========================================================
    // 🔥 4. {key:value} → ["key"=>value]
    // =========================================================
    $code = preg_replace_callback('/\{([^{}]*)\}/', function($m) use ($strings) {

        $inner = trim($m[1]);
        $pairs = explode(',', $inner);
        $result = [];

        foreach ($pairs as $pair) {

            list($k, $v) = array_map('trim', explode(':', $pair, 2));

            $k = '"' . $k . '"';

            if (isset($strings[$v])) {
                $val = $strings[$v];
            } else if (is_numeric($v)) {
                $val = $v;
            } else {
                $val = '"' . $v . '"';
            }

            $result[] = $k . '=>' . $val;
        }

        return '[' . implode(', ', $result) . ']';

    }, $code);

    // =========================================================
    // 🔥 5. collect 변환
    // =========================================================
    $code = preg_replace('/\(\$(\w+)\)/', 'collect($$1)', $code);

    // =========================================================
    // 🔥 6. 체이닝 메서드
    // =========================================================
    $methods = ['where','map','get','groupBy','sortBy','limit','pluck','select'];

    foreach ($methods as $m) {
        $code = str_replace('.' . $m, '->' . $m, $code);
    }

    // =========================================================
    // 🔥 7. where DSL
    // =========================================================
    $code = preg_replace_callback('/->where\((.*?)\)/', function($m) {

        $expr = trim($m[1]);

        // 단일 조건
        if (preg_match('/^\w+\s*[><=!]+\s*\d+$/', $expr)) {

            preg_match('/(\w+)\s*([><=!]+)\s*(\d+)/', $expr, $p);
            return '->where("'.$p[1].'","'.$p[2].'",'.$p[3].')';
        }

        // 🔥 변수 치환 (placeholder 보호 핵심🔥)
        $expr = preg_replace_callback('/\b([a-zA-Z_]\w*)\b/', function($m) {

            $word = $m[1];

            if (strpos($word, '__STR') === 0) return $word;
            if (is_numeric($word)) return $word;

            if (in_array(strtolower($word), ['true','false','null'])) {
                return $word;
            }

            return '$item["' . $word . '"]';

        }, $expr);

        return '->where(function($item){ return ' . $expr . '; })';

    }, $code);

    // =========================================================
    // 🔥 8. map DSL
    // =========================================================
    $code = preg_replace_callback('/->map\((.*?)\)/', function($m) {

        $expr = trim($m[1]);

        if (preg_match('/^\w+$/', $expr)) {
            return '->map(function($item){ return $item["'.$expr.'"]; })';
        }

        $expr = preg_replace_callback('/\b([a-zA-Z_]\w*)\b/', function($m) {

            $word = $m[1];

            if (strpos($word, '__STR') === 0) return $word;
            if (is_numeric($word)) return $word;

            return '$item["' . $word . '"]';

        }, $expr);

        $expr = str_replace('+', '.', $expr);

        return '->map(function($item){ return ' . $expr . '; })';

    }, $code);

    // =========================================================
    // 🔥 9. for → foreach
    // =========================================================
    $code = preg_replace(
        '/for\s+\$(\w+)\s+in\s+\$(\w+)/',
        'foreach ($$2 as $$1) {',
        $code
    );

    // =========================================================
    // 🔥 10. end → }
    // =========================================================
    $code = str_replace('end', '}', $code);

    // =========================================================
    // 🔥 11. 세미콜론 보정
    // =========================================================
    $code = preg_replace('/Trace::on\(\)/', 'Trace::on();', $code);
    $code = preg_replace('/Trace::off\(\)/', 'Trace::off();', $code);
    $code = preg_replace('/->get\(\)/', '->get();', $code);
    $code = preg_replace('/\]\s*(\$)/', ']; $1', $code);

    // print 보정
    $code = preg_replace('/Msg::print\w*/', 'Msg::print', $code);
    $code = preg_replace('/Msg::print\((.*?)\)(?!;)/', 'Msg::print($1);', $code);

    // foreach 내부 세미콜론
    $code = preg_replace(
        '/foreach\s*\((.*?)\)\s*\{\s*([^;{}]+)\s*\}/',
        'foreach ($1) { $2; }',
        $code
    );

    // =========================================================
    // 🔥 12. 문자열 복구 (마지막 단 한 번)
    // =========================================================
    foreach ($strings as $k => $v) {
        $code = str_replace($k, $v, $code);
    }

    return $code;
}
?>