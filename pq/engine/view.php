<?php
/**
 * PQ Engine View System (v1.2.7) - [과학수사팀 특수 제작]
 * [사건 종결] CSS/JS 마침표 오인 사격 및 endforeach 중복 오류 영구 소탕
 * [수사 원칙] 모든 렌더링물은 성역 격리 후 안전하게 pq_ready를 집행한다.
 */

function pq_view($view_name, $data = []) {
    // 1. 현장 확인 (파일 수색)
    $view_path = $_SERVER['DOCUMENT_ROOT'] . "/html/" . $view_name;
    if (!file_exists($view_path)) {
        $view_path .= (file_exists($view_path . ".pq")) ? ".pq" : ".php";
    }
    
    if (!file_exists($view_path)) return "🕵️ [수사 실패] View 현장을 찾을 수 없습니다: $view_path";

    $content = file_get_contents($view_path);
    
    // [Step 1] 성역(Sanctuary) 격리 - CSS, JS, <pq> 태그 보존
    $placeholders = [];
    $content = preg_replace_callback('/<(style|script|pq)>(.*?)<\/\1>/is', function($m) use (&$placeholders) {
        $id = "___PQ_VIEW_SANCTUARY_" . count($placeholders) . "___";
        $placeholders[$id] = $m[0]; 
        return $id; 
    }, $content);

    /**
     * [Step 2] 구문 번역 수사 (지능형 변환)
     */
    // A. 출력 및 일반 구문 통합 처리
    $content = preg_replace_callback('/\[\[\s*(.*?)\s*\]\]/s', function($matches) {
        $inner = trim($matches[1]);
        if (empty($inner)) return "";

        // 🚨 [범인 체포] 제어문은 파서가 간섭 못하게 태그 쪼개기 기법 적용
        $lower_inner = strtolower($inner);
        if ($lower_inner === 'end') return "?><?php endforeach; ?><?php ";
        if ($lower_inner === 'endif') return "?><?php endif; ?><?php ";

        // import 수사
        if (str_starts_with($inner, 'import')) {
            $file = str_replace(['import', '"', "'", ';', ' '], '', $inner);
            $ext = str_contains($file, '.') ? '' : '.pq';
            return "<?php include_once \$_SERVER['DOCUMENT_ROOT'] . '/html/' . '{$file}{$ext}'; ?>";
        }

        $is_echo = str_starts_with($inner, '=');
        $code = $is_echo ? ltrim($inner, '= ') : $inner;

        // pq_ready 정밀 세탁기 돌리기
        $final = function_exists('pq_ready') ? pq_ready($code) : $code;
        $final = rtrim(trim($final), ';') . ";";

        return $is_echo ? "<?php echo $final ?>" : "<?php $final ?>";
    }, $content);

    // B. {{ }} 간편 출력 수사
    $content = preg_replace('/{{\s*(.*?)\s*}}/', '<?php echo pq_clean($1); ?>', $content);

    // [Step 3] 성역 복구 (CSS/JS를 안전하게 현장에 재배치)
    foreach ($placeholders as $id => $val) { 
        $content = str_replace($id, $val, $content); 
    }

    // [Step 4] 유령 태그 청소 및 최종 코드 확정
    $php_code = str_replace('<?php ?>', '', $content);

    // [Step 5] 실전 집행 (Debug 모드 대응)
    if (isset($GLOBALS['PQ_DEBUG_ON']) && $GLOBALS['PQ_DEBUG_ON']) {
        echo "<fieldset style='border:1px solid #0f0; background:#000; color:#0f0; padding:10px;'>";
        echo "<legend> 🕵️ [과학수사 VIEW 리포트] </legend>";
        echo "<textarea style='width:100%; height:150px; background:#111; color:#0f0; border:none; font-family:consolas;'>" . htmlspecialchars($php_code) . "</textarea></fieldset>";
    }

    ob_start();
    if (!empty($data)) extract($data); 
    
    try {
        eval("?>" . $php_code);
    } catch (Throwable $e) {
        // 과학수사팀 에러 보고서
        echo "<div style='color:#fff; background:#900; border:3px double #f00; padding:20px; font-family:monospace;'>";
        echo "<h3>🚨 PQ 과학수사대 긴급 브리핑</h3>";
        echo "<p><b>사건명:</b> " . $e->getMessage() . "</p>";
        echo "<p><b>발생지:</b> Line " . $e->getLine() . "</p>";
        echo "</div>";
    }
    
    $output = ob_get_clean();

    // [Step 6] 공백 결착 최적화
    $output = preg_replace('/>\s+(?=[^<])/u', '>', $output);
    $output = preg_replace('/(?<=[^>])\s+</u', '<', $output);

    return $output;
}
?>
