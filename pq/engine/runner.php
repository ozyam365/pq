<?php
/**
 * PQ Runner (v1.0.1) - 안정화 및 감식 모드
 */

function run_pq($file_path) {
    if (!file_exists($file_path)) {
        echo "<div class='alert alert-danger'>🕵️ 수사 대상이 없습니다: $file_path</div>";
        return;
    }
    $raw_source = file_get_contents($file_path);

    // 1. [문법 번역]
    $translated_code = pq_ready($raw_source);

    // 2. [광속 치환]
    $ready_code = str_replace(['[[', ']]'], ['<?php ', ' ?>'], $translated_code);

    // 3. [실전 집행]
    try {
        /**
         * 🕵️ 수사관 현장 감식 (필요할 때만 주석을 해제하세요)
         * 7번 라인 에러가 날 때 아래 블록 주석을 풀면 범인이 보입니다.
         */
        /*
        echo "<div style='background:#000; color:#0f0; padding:10px; border:2px solid red;'>";
        echo "<h4>🕵️ PQ 변환 코드 감식 결과 (Line 7 수색)</h4>";
        $lines = explode("\n", $ready_code);
        foreach($lines as $i => $l) {
            $num = $i + 1;
            $style = ($num == 7) ? "background:red; color:white; font-weight:bold;" : "";
            echo "<div style='$style'>$num: " . htmlspecialchars($l) . "</div>";
            if($num > 20) break;
        }
        echo "</div>";
        exit;
        */

        eval("?> " . $ready_code); 

    } catch (Throwable $e) {
        echo "<div class='alert alert-danger' style='font-size:13px; border-left:5px solid red;'>";
        echo "❌ <b>PQ Engine 수사 오류:</b> " . htmlspecialchars($e->getMessage()) . "<br>";
        echo "📍 <b>의심 지점:</b> " . basename($file_path) . " (Line: " . $e->getLine() . ")";
        echo "</div>";
    }
}
?>
