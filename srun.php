<?php
/**
 * PQ Sample Runner (srun.php) - Trace 클래스 로드 보강 버전
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('_PQ_EXEC_', true);

$root = __DIR__;

// 1. [핵심] Trace 클래스와 필수 Core 파일을 절대 경로로 명시적 로드
require_once $root . "/pq/core/trace.php";   // 🔥 1순위 로드
require_once $root . "/pq/core/session.php";
require_once $root . "/pq/core/db.php";
require_once $root . "/pq/core/http.php";
require_once $root . "/pq/core/util.php";
require_once $root . "/pq/core/func.php";

// 2. [Engine 로드]
require_once $root . "/pq/engine/ready.php";
require_once $root . "/pq/engine/runner.php";

// 3. [예약어 실체화]
$session = session_pq();
$db      = db();
$http    = http_pq();
$form    = form_pq();

// 4. [타겟 수사]
//$file = $_GET['f'] ?? 'final_spec';
$file = $_GET['f'] ?? 'paging_test';
$target_path = $root . "/sample/" . str_replace('.pq', '', $file) . ".pq";

// UI 출력부
echo "<div style='background:#0f172a; color:#38bdf8; padding:15px; font-family:Consolas, monospace; border-radius:8px; margin:10px; border:1px solid #1e293b;'>";
echo "<b style='color:#22c55e;'>🔍 PQ 수사 본부 가동</b><br>";
echo "<span style='color:#64748b;'>🎯 대상:</span> " . basename($target_path);
echo "</div>";

if (file_exists($target_path)) {
    // 세션 초기화
    $session->init();
    
    // 최종 실행
    run_pq($target_path); 

    // 🔥 수사가 끝난 후 Trace 리포트 출력
    if (class_exists('Trace') && Trace::is_active()) {
        Trace::out();
    }
} else {
    echo "<div style='color:#ef4444; padding:20px;'>🚨 수사 실패: 파일을 찾을 수 없습니다.</div>";
}
?>
