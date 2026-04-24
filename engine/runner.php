<?php
function run_pq($file) {
    global $subject, $note, $author;

    $code = file_get_contents($file);

    // 변수
    $code = str_replace("@", "$", $code);

    // now()
    $code = str_replace("now()", "date('Y-m-d H:i:s')", $code);

    // msg.print
    $code = str_replace("msg.print", "Msg::print", $code);

    // range 처리 (간단 버전)
    $code = preg_replace(
        '/for\s+\$(\w+)\s+in\s+range\((\d+),\s*(\d+)\)/',
        'for ($$1 = $2; $$1 < $3; $$1++)',
        $code
    );

    // end → }
    $code = str_replace("end", "}", $code);

    // for → { 추가
    $code = preg_replace('/for\s*\((.*?)\)/', 'for ($1) {', $code);

    eval($code);
}