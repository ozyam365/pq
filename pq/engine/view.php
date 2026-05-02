<?php
<?php
// /pq/engine/view.php

function pq_view($view_name, $data = []) {
    $view_path = $_SERVER['DOCUMENT_ROOT'] . "/html/" . $view_name . ".php";
    if (!file_exists($view_path)) return "🔍 View Not Found: $view_path";

    $content = file_get_contents($view_path);
    
    // 1. 단축 문법 수색 및 번역
    $content = preg_replace('/{{\s*(.*?)\s*}}/', '<?php echo pq_clean($1); ?>', $content);
    $content = preg_replace('/\[\[\s*(.*?)\s*\]\]/', '<?php echo $1; ?>', $content);

    $php_code = pq_ready($content);

    // 2. [수사 지침 제2원칙] 디버그 스위치 작동 시 보고서 출력
    if (isset($GLOBALS['PQ_DEBUG_ON']) && $GLOBALS['PQ_DEBUG_ON']) {
        echo "<fieldset style='border:1px solid #0f0; background:#000; color:#0f0; margin:10px 0;'><legend> [VIEW 수사보고] </legend>";
        echo "<textarea style='width:100%; height:150px; background:#111; color:#0f0; border:none;'>$php_code</textarea></fieldset>";
    }

    // 3. [실전 집행] 출력 버퍼링 가동
    ob_start();
    if (!empty($data)) extract($data); 
    
    try {
        eval("?>" . $php_code);
    } catch (Throwable $e) {
        // [수사 지침 제3원칙] 괄호/커플 미결착 에러 대응
        echo "❌ [제3원칙 위반] 문법 커플이 맞지 않습니다: " . $e->getMessage();
    }
    
    $output = ob_get_clean();

    /**
     * 🕵️‍♂️ [공백 결착 수사대] 
     * 태그와 텍스트 사이의 강제 개행을 소탕하여 레이아웃을 완전히 밀착시킵니다.
     */
    
    // 지침: 태그 종료(>)와 다음 글자 사이의 개행/공백을 싹 제거합니다.
    $output = preg_replace('/>\s+([^<])/u', '>$1', $output);
    
    // 지침: 글자와 다음 태그 시작(<) 사이의 공백도 결속시킵니다.
    $output = preg_replace('/([^>])\s+</u', '$1<', $output);

    return $output;
}

?>