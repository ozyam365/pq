<?php
/**
 * PQ Sample Runner (srun.php) - 최종 보급로 확보 버전
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('_PQ_EXEC_', true);

$root = __DIR__;

// 1. [핵심] 모든 수사 요원(Core)을 명시적으로 집합시킴 (누락 방지)
require_once $root . "/pq/core/trace.php";
require_once $root . "/pq/core/session.php";
require_once $root . "/pq/core/db.php";
require_once $root . "/pq/core/file.php";   // 🕵️ 검거 완료
require_once $root . "/pq/core/date.php";   // 🕵️ 검거 완료
require_once $root . "/pq/core/form.php";   // 🕵️ 검거 완료 (form_pq 에러 해결)
require_once $root . "/pq/core/text.php";   // 🕵️ 검거 완료
require_once $root . "/pq/core/http.php";
require_once $root . "/pq/core/util.php";
require_once $root . "/pq/core/func.php";

// 2. [Engine 로드]
require_once $root . "/pq/engine/ready.php";
require_once $root . "/pq/engine/runner.php";

// 3. [예약어 실체화] - 이제 모든 수사팀이 제 위치에 있습니다.
$session = session_pq();
$db      = db();
$http    = http_pq();
$form    = form_pq();
$file    = file_pq(); // 🕵️ 추가 (listdir null 에러 해결)

// 4. [타겟 수사]
$file_param = $_GET['f'] ?? 'check';
$target_path = $root . "/sample/" . str_replace('.pq', '', $file_param) . ".pq";

// UI 출력부 (생략 가능하나 가독성을 위해 유지)
echo "<div style='background:#0f172a; color:#38bdf8; padding:15px; font-family:Consolas, monospace; border-radius:8px; margin:10px; border:1px solid #1e293b;'>";
echo "<b style='color:#22c55e;'>🔍 PQ 수사 본부 가동</b><br>";
echo "<span style='color:#64748b;'>🎯 대상:</span> " . basename($target_path);
echo "</div>";

if (file_exists($target_path)) {
    // 세션 초기화 및 실행
    $session->init();
    run_pq($target_path); 

    // 수사 종료 후 Trace 리포트
    if (class_exists('Trace') && Trace::is_active()) {
        Trace::out();
    }
} else {
    echo "<div style='color:#ef4444; padding:20px;'>🚨 수사 실패: 파일을 찾을 수 없습니다.</div>";
}
?>