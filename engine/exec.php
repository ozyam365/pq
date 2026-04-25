<?php

function pq_execute($code) {

    // 🔥 디버그용 (필요하면 켜세요)
    // echo "\n===== FINAL CODE =====\n";
    // echo $code . "\n";
    // echo "======================\n";

    try {
        $start = microtime(true);

        // 🔥 핵심: 절대 쪼개지 말고 그대로 실행
        eval($code);

        $time = microtime(true) - $start;

        Trace::timeLine(0, "[COMPLETE]", $time);
        Trace::ok();

    } catch (Throwable $e) {

        Trace::error(
            "Line " . $e->getLine() . " → " . $e->getMessage()
        );
    }

    Trace::output();
}