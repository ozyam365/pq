<?php
function pq_view($view_name, $data = []) {
    $view_path = $_SERVER['DOCUMENT_ROOT'] . "/html/" . $view_name . ".php";
    if (!file_exists($view_path)) return "🔍 View Not Found: $view_path";

    $content = file_get_contents($view_path);
    $content = preg_replace('/{{\s*(.*?)\s*}}/', '<?php echo pq_clean($1); ?>', $content);
    $content = preg_replace('/\[\[\s*(.*?)\s*\]\]/', '<?php echo $1; ?>', $content);

    $php_code = pq_ready($content);

    if (isset($GLOBALS['PQ_DEBUG_ON']) && $GLOBALS['PQ_DEBUG_ON']) {
        echo "<fieldset style='border:1px solid #0f0; background:#000; color:#0f0; margin:10px 0;'><legend> [VIEW 수사보고] </legend>";
        echo "<textarea style='width:100%; height:150px; background:#111; color:#0f0; border:none;'>$php_code</textarea></fieldset>";
    }

    ob_start();
    if (!empty($data)) extract($data); 
    eval("?>" . $php_code);
    return ob_get_clean();
}