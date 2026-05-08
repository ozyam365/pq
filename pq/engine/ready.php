<?php
/**
 * PQ 번역관 (v0.8.9 - 통합 수사 규격)
 * [수사 지침] runner.php와 동일한 객체 지향 규격을 사용하여 이중 번역 오류를 방지한다.
 */

// 코어 모듈 로드 (절대 경로)
$core_path = dirname(__DIR__, 1) . "/core";
include_once $core_path . "/util.php";
include_once $core_path . "/db.php";
include_once $core_path . "/file.php";
include_once $core_path . "/session.php";
include_once $core_path . "/http.php";

function pq_ready($code) {
    if (empty(trim((string)$code))) return '';

    // 1. [시스템 예약어] 15대 수사관 객체 직결 ($r->)
    $reserved = ['db', 'session', 'http', 'file', 'form', 'date', 'time', 'ai', 'iot', 'app', 'trace'];
    foreach ($reserved as $r) {
        $bridge = ($r === 'trace') ? 'Trace::' : '$' . $r . '->';
        // 이미 화살표(->)가 붙은 경우는 건너뛰고, 마침표(.)인 경우만 치환
        $code = preg_replace('/(?<![\w\->])' . $r . '\./i', $bridge, $code);
    }

    // 2. [변수 신분 세탁] @를 $로 변환
    $code = preg_replace([
        '/\((@\w+)\)\./',  // (@var). -> $var->
        '/\((@\w+)\)/',    // (@var)  -> ($var)
    ], [
        '${1}->',
        '($1)'
    ], $code);

    $code = str_replace('@', '$', $code);

    // 3. [기타 유틸리티 결착]
    $code = preg_replace('/trace\(/i', 'Trace::add(', $code);
    $code = str_ireplace(['trace->on', 'debug->on'], 'Trace::on', $code);

    return trim($code);
}
?>