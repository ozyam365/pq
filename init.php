<?php
define('ROOT', __DIR__);

// 에러 표시
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 공통
require_once ROOT . '/core/lib.php';
// 설정
require_once ROOT . '/set/db.php';
// DB 연결
require_once ROOT . '/core/db.php';
?>