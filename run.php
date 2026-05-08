<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$root = dirname(__FILE__);

// 1. 코어 로드 (util.php가 autoRoute를 들고 옵니다)
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

if (function_exists('http')) http()->safe();

// 3. 라우팅 설정 (여기서 autoRoute 함수 정의는 삭제하고 호출만 합니다)
PQRouter::set('/index', 'html/intro/index.pq');
PQRouter::set('/intro', 'html/intro/index.pq');
PQRouter::set('/license', 'html/intro/license.pq');
PQRouter::set('/lab', 'html/test/lab.pq');

// 이제 util.php에 정의된 autoRoute를 사용합니다.
autoRoute($root . '/html/db', '/db');
autoRoute($root . '/html/file', '/file');
autoRoute($root . '/html/http', '/http');
//autoRoute($root . '/html/core', '/core');
autoRoute($root . '/html/util', '/util');
autoRoute($root . '/html/service', '/service');
autoRoute($root . '/html/sample', '/sample');

// ... 이하 라우터 실행 및 출력 로직 동일 ...
$relative_path = PQRouter::run();
$target_pq = false;
if ($relative_path) {
    if (file_exists($relative_path)) $target_pq = $relative_path;
    else {
        $full_path = $root . '/' . ltrim($relative_path, '/');
        if (file_exists($full_path)) $target_pq = $full_path;
    }
}

include_once $root . "/html/layout/header.php"; 
echo '<div class="pq-container">';
    include_once $root . "/html/layout/sidebar.php";
    echo '<main class="pq-main"><div class="pq-section">';
        if ($target_pq && is_file($target_pq)) {
            run_pq($target_pq);
            if (class_exists('Trace') && Trace::is_active()) Trace::out();
        } else {
            echo "<h2>🕵️ 수사 실패</h2>";
        }
    echo '</div>'; 
    include_once $root . "/html/layout/footer.php";
echo '</main></div>';
?>
