<?php
/**
 * PQ Runner (v0.9.8)
 * [최종 정제] 실행부 구조 결착 및 버퍼링 수사 강화
 */

function run_pq($file_path) {
    // 1. [현장 감식] 소스 로드 및 주석 제거
    $clean_source = pq_load_optimized($file_path);
    if (!$clean_source || empty(trim((string)$clean_source))) return;

    // 2. [수사견 파견] 디버그 모드 감지
    $is_debug = (stripos((string)$clean_source, 'trace.on') !== false || stripos((string)$clean_source, 'debug.on') !== false);

    // 3. [문법 번역] ready.php를 통한 PQ 문법 세탁
    // pq_ready() 함수는 외부(ready.php)에서 정의되어 있다고 가정합니다.
    $ready_code = pq_ready($clean_source);

    // 4. [수사 보고] 디버그 모드 시 번역 코드 출력
    if ($is_debug) {
        echo "<div class='card shadow-sm mb-4 border-0'>";
        echo "<div class='card-header bg-dark text-white py-2'><h6 class='mb-0' style='font-size:13px;'>⚡ PQ Execution Report</h6></div>";
        echo "<div class='card-body p-0' style='background:#fdfdfd;'>";
        echo "<pre class='m-0 p-3' style='font-size:13px;'><code>" . htmlspecialchars($ready_code) . "</code></pre>";
        echo "</div></div>";
    }

    // 5. [실전 집행] 출력부 정제 및 캡슐화
    $wrapper_class = $is_debug ? "p-4 mb-4 bg-white border rounded-3 shadow-sm" : "pq-output-prod";
    echo "<div class='{$wrapper_class} pq-final-sector' style='white-space: normal !important; word-break: break-all;'>";
    
    try {
        ob_start();
        // PHP 닫는 태그 후 코드를 넣어야 eval이 PHP 코드로 인식합니다.
        eval("?> " . trim($ready_code)); 
        $output = ob_get_clean();

        // (1) 성역(style, pre, script) 보호소 대피
        $safe_blocks = [];
        $output = preg_replace_callback('/<(pre|style|script).*?>.*?<\/\1>/is', function($matches) use (&$safe_blocks) {
            $token = "[[PQ_SAFE_ZONE_" . count($safe_blocks) . "]]";
            $safe_blocks[$token] = $matches[0]; 
            return $token;
        }, $output);

        // (2) 인라인 개행 및 탭 소탕 (진공 상태)
        $output = str_replace(["\r\n", "\r", "\n", "\t"], "", (string)$output);
        $output = preg_replace('/>\s+</u', '><', $output);
        $output = preg_replace('/>\s+([^<])/u', '>$1', $output);

        // (3) 성역 복구
        if (!empty($safe_blocks)) {
            foreach ($safe_blocks as $token => $content) {
                $output = str_replace($token, $content, $output);
            }
        }
        echo trim((string)$output);

    } catch (Throwable $e) {
        if (ob_get_level() > 0) ob_get_clean(); 
        echo "<div class='alert alert-danger' style='font-size:13px;'>";
        echo "❌ <b>PQ Engine Error:</b> " . htmlspecialchars($e->getMessage()) . "<br>";
        echo "<small>Line: " . $e->getLine() . "</small>";
        echo "</div>";
    }
    echo "</div>";
}

function pq_load_optimized($file_path) {
    if (!file_exists($file_path)) return "";
    
    $lines = file($file_path);
    $clean_code = "";
    $in_multiline = false;

    foreach ($lines as $line) {
        $trimmed_line = trim($line);
        if (str_contains($trimmed_line, '/*')) $in_multiline = true;
        
        if (!$in_multiline) {
            // URL(//) 보호하며 주석 제거
            $line = preg_replace('/(?<!http:|https:)\/\/.*$/', '', $line);
            $clean_code .= $line;
        }
        
        if (str_contains($trimmed_line, '*/')) $in_multiline = false;
    }
    return $clean_code;
}
?>