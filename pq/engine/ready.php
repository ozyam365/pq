<?php
/**
 * PQ 번역관 (v0.8.7 - Anti-Double Dollar)
 * [수사 지침] 변수 세탁 시 달러 기호를 단 하나만 정교하게 결착한다.
 */
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
?>