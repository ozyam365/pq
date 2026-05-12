<?php
/**
 * PQ 엔진 점화 (ready.php v1.1.7)
 * [헌법 집행] 배열 신분 명시권(@변수[]) 수용 및 정밀 번역 로직 탑재
 * [사건 종결] 엔진 격리용 치환자(___PQ_...) 보호 유지
 */

$root_path = dirname(__DIR__, 1);
include_once $root_path . "/core/util.php";
include_once $root_path . "/core/db.php";
include_once $root_path . "/core/file.php";
include_once $root_path . "/core/session.php";
include_once $root_path . "/core/http.php";
include_once $root_path . "/core/func.php";
include_once $root_path . "/core/date.php";
include_once $root_path . "/core/form.php"; 
include_once $root_path . "/core/text.php"; 

function pq_ready($code) {
    if (empty(trim((string)$code))) return '';

    // [Step 1] 문자열 보호 (변함없음)
    $strings = [];
    $code = preg_replace_callback('/(["\'])(?:(?=(\\\\?))\2.)*?\1/', function($m) use (&$strings) {
        $id = "___STR_READY_" . count($strings) . "___";
        $strings[$id] = $m[0];
        return $id;
    }, $code);

    // [Step 2] 예약어 특권 및 연쇄 체이닝 집행
    $reserved = ['db', 'session', 'http', 'file', 'form', 'date', 'time', 'text', 'ai', 'iot', 'app', 'trace', 'util'];
    foreach ($reserved as $r) {
        $bridge = ($r === 'trace') ? 'Trace::' : '$' . $r . '->';
        $code = preg_replace('/(?<![\$a-zA-Z0-9_])' . $r . '\.([a-zA-Z_])/i', $bridge . '$1', $code);
    }

    /**
     * 🕵️ [Step 3] 변수 신분 세탁 (배열 명시권 최우선 집행)
     * 1. @변수[] -> $변수 (배열 전체를 지칭할 때 사용)
     * 2. @변수 -> $변수 (일반 변수)
     */
    $code = preg_replace('/@([a-zA-Z_][a-zA-Z0-9_]*)\[\]/', '$$1', $code); // 배열 명시 처리
    $code = preg_replace('/@([a-zA-Z_][a-zA-Z0-9_]*)/', '$$1', $code);      // 일반 변수 처리

    /**
     * [Step 4] 무한 체이닝 수사망
     * (변수나 함수 뒤의 점) + (영문자) 조합을 찾아 -> 로 바꿉니다.
     * 단, 엔진의 격리용 이름인 ___PQ_... 가 포함된 경우는 절대 건드리지 않습니다.
     */
    $code = preg_replace('/(?<!___PQ_)([a-zA-Z0-9_)]+)\.([a-zA-Z_])/', '$1->$2', $code);

    // [Step 5] 문자열 복구
    foreach ($strings as $id => $val) { 
        $code = str_replace($id, $val, $code); 
    }

    // [Step 6] Trace 예외 보정
    $code = preg_replace('/(?<!->)trace\(/i', 'Trace::add(', $code);

    return trim($code);
}
?>
