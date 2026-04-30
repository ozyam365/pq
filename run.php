<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. 설정 및 엔진 로드
require_once __DIR__ . '/set/cfg_app.php';
require_once __DIR__ . '/set/cfg_db.php';
require_once __DIR__ . '/set/cfg_env.php';
include_once __DIR__ . "/engine/runner.php";
include_once __DIR__ . "/engine/router.php"; // 라우터 클래스 포함

// 2. [라우팅 정의] URL 패턴과 실행할 .pq 파일을 연결
// :idx 같은 값은 자동으로 @idx 변수가 됩니다.
PQRouter::set('/', 'sample/police.pq');
PQRouter::set('/user/:idx', 'sample/user_view.pq'); 
PQRouter::set('/test/:category/:id', 'sample/test.pq');

// 3. 실행할 파일 결정 (PATH_INFO 방식)
// 예: run.php/user/10 -> @idx = 10 주입됨
$req_path = $_SERVER['PATH_INFO'] ?? '/';
$target_file = PQRouter::execute($req_path);

// 기존 GET 방식과 호환성을 유지하려면 아래 한 줄 추가
if(isset($_GET['f'])) $target_file = "sample/{$_GET['f']}.pq";

$file = __DIR__ . "/" . ltrim($target_file, '/');

if (!file_exists($file)) {
    echo "🔍 PQ File Not Found: $file";
    exit;
}

// 4. PQ 실행
run_pq($file);

// 5. Trace 출력
if (class_exists('Trace')) {
    Trace::dump();
}
?>