<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$root = dirname(__FILE__);

// 1. 코어 로드
require_once $root . "/pq/core/util.php"; 
require_once $root . "/pq/core/func.php";
require_once $root . "/pq/core/trace.php";
require_once $root . "/pq/core/session.php";
require_once $root . "/pq/core/http.php";
require_once $root . "/pq/core/db.php";
require_once $root . "/pq/core/list.php";

// 2. 엔진 로드
require_once $root . "/pq/engine/ready.php";
require_once $root . "/pq/engine/runner.php";
require_once $root . "/pq/engine/router.php";

// HTTP 보안 수사망 가동
if (function_exists('http')) http()->safe();

// 3. 라우팅 설정
PQRouter::set('/index', 'html/intro/index.pq');
PQRouter::set('/intro', 'html/intro/index.pq');
PQRouter::set('/license', 'html/intro/license.pq');
PQRouter::set('/lab', 'html/test/lab.pq');

// 자동 수사망(autoRoute) 확장
autoRoute($root . '/html/db', '/db');
autoRoute($root . '/html/file', '/file');
autoRoute($root . '/html/http', '/http');
autoRoute($root . '/html/session', '/session');
autoRoute($root . '/html/form', '/form');
autoRoute($root . '/html/date', '/date');
autoRoute($root . '/html/util', '/util');
autoRoute($root . '/html/service', '/service');
autoRoute($root . '/html/sample', '/sample');

// 4. 경로 수사 시작
$relative_path = PQRouter::run();
$target_pq = false;

if ($relative_path) {
    // 절대 경로 우선 검문
    $full_path = (strpos($relative_path, $root) === 0) ? $relative_path : $root . '/' . ltrim($relative_path, '/');
    if (file_exists($full_path) && is_file($full_path)) {
        $target_pq = $full_path;
    }
}

// 5. 현장 렌더링 (View)
include_once $root . "/html/layout/header.php"; 

echo '<div class="pq-container">';
    include_once $root . "/html/layout/sidebar.php";
    echo '<main class="pq-main">';
        echo '<div class="pq-section">';
            if ($target_pq) {
                run_pq($target_pq); // PQ 엔진 가동
            } else {
                echo "<div class='alert alert-danger'><h2>🕵️ 수사 실패</h2><p>용의 파일을 찾을 수 없습니다: $relative_path</p></div>";
            }
        echo '</div>'; // pq-section 종료
        
        // 수사견(Trace) 보고서는 푸터 직전에 출력
        if (class_exists('Trace') && Trace::is_active()) {
            echo '<hr style="border-top: 2px dashed #ccc; margin-top: 50px;">';
            Trace::out();
        }
    echo '</main>';
echo '</div>'; // pq-container 종료

include_once $root . "/html/layout/footer.php";

ob_end_flush(); // 수사 보고 종료
?>