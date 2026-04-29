<?php
foreach (glob(__DIR__ . "/../core/*.php") as $file) include_once $file;
include_once __DIR__ . "/ready.php";

function run_pq($target_path = null) {
    global $full_path; // ready.php에서 쓰도록 전역 선언
    
    $req = ltrim($target_path ?? ($_SERVER['PATH_INFO'] ?? '/index.pq'), '/');
    $req = str_replace('pq365/www/', '', $req); 
    
    $full_path = realpath(__DIR__ . "/../" . $req); 

    if ($full_path && file_exists($full_path)) {
        $raw = file_get_contents($full_path);
        eval(pq_ready($raw)); // eval 내부에서 pq_ready가 돌 때 전역변수 참조
    } else {
        echo "PQ Error: File not found at " . $full_path;
    }
}

?>