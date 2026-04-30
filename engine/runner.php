<?php
$base_dir = __DIR__;
include_once $base_dir . "/ready.php";
include_once $base_dir . "/view.php";
foreach (glob($base_dir . "/../core/*.php") as $file) include_once $file;

function run_pq($target_path = null) {
    global $full_path;
    $req = ltrim($target_path ?? ($_SERVER['PATH_INFO'] ?? '/index.pq'), '/');
    $req = str_replace('pq365/www/', '', $req); 
    $full_path = realpath(__DIR__ . "/../" . $req); 
    if ($full_path && file_exists($full_path)) {
        $ready_code = pq_ready(file_get_contents($full_path));
        if (isset($GLOBALS['PQ_DEBUG_ON']) && $GLOBALS['PQ_DEBUG_ON']) {
            echo "<textarea style='width:100%; height:150px; background:#222; color:#0f0;'>$ready_code</textarea>";
        }
// engine/runner.php (eval 호출 직전)
echo "<pre>"; 
echo htmlspecialchars($ready_code); 
echo "</pre>";
exit;
        eval($ready_code); 
    }
}



?>