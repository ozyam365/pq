<?php
require_once ROOT . '/core/msg.php';
require_once ROOT . '/core/trace.php';
require_once ROOT . '/core/http.php';
require_once ROOT . '/core/collection.php';
require_once ROOT . '/core/db.php';

require_once __DIR__ . '/filter.php';
require_once __DIR__ . '/ready.php';
require_once __DIR__ . '/exec.php';


function run_pq($file) {

    Trace::start();   // 🔥 시작 (여기만!)

    $code = file_get_contents($file);

    if ($code === false) {
        echo "❌ Cannot read file";
        return;
    }

    if (!pq_is_safe($code)) {
        echo "❌ Unsafe code detected";
        return;
    }

    $code = pq_preprocess($code);

    pq_execute($code);

    // ❌ 여기서 end() 절대 호출하지 않음

}