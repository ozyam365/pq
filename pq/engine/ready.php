<?php
/**
 * PQ 번역관 (v0.8.7 - Anti-Double Dollar)
 * [수사 지침] 변수 세탁 시 달러 기호를 단 하나만 정교하게 결착한다.
 */
 // 1. 핵심 유틸리티(함수들)를 먼저 불러와야 예약어 함수들을 쓸 수 있습니다.
include_once __DIR__ . "/../../pq/core/util.php";
include_once __DIR__ . "/../../pq/core/db.php";
include_once __DIR__ . "/../../pq/core/file.php";
// ... 나머지 코어 파일들

// 2. 그 다음 시스템 예약어 변수를 할당합니다.
$form    = form_pq();    // 이제 util.php를 읽었으므로 에러가 나지 않습니다.
$db      = db();
$file    = file_pq();
$date    = date_pq();
$time    = time_pq();
function pq_ready($code) {
    if (empty(trim((string)$code))) return '';

    // 1. [시스템 예약어] 15대 수사관 직진 (session, db, date 등)
    $reserved = ['db', 'session', 'http', 'file', 'form', 'date', 'time', 'qrcode', 'mail', 'chat', 'sys', 'iot', 'app'];
    foreach ($reserved as $r) {
        $code = preg_replace('/(?<![@\w])' . $r . '\.([a-zA-Z_]\w*)/i', $r . '_pq()->$1', $code);
    }

    // 2. [변수 신분 세탁] @를 $로 변환 (중복 방지 로직)
    // 괄호()나 점(.)에 붙은 @변수들을 먼저 안전하게 처리
    $code = preg_replace([
        '/\((@\w+)\)\./',  // (@var). -> $var->
        '/\((@\w+)\)/',    // (@var)  -> ($var)
    ], [
        '${1}->',
        '($1)'
    ], $code);

    // 최종적으로 모든 @를 $로 일괄 치환 (달러 기호 하나만 생성되도록 결착)
    $code = str_replace('@', '$', $code);

    // 3. [기타 유틸리티 결착]
    $code = preg_replace('/trace\(/i', 'Trace::add(', $code);
    $code = str_ireplace(['trace->on', 'debug->on'], 'Trace::on', $code);
    return trim($code);
}
	$form = form_pq(); 
?>

