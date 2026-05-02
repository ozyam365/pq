<?php
/**
 * PQ HTTP Manager (v0.8.8)
 * [수사 지침] 입출입 보안 세탁 및 경로 제어를 전담한다.
 */

// [1] 시스템 예약어 결착 함수 (ready.php가 이 이름을 찾습니다)
function http_pq() { 
    static $h = null; 
    if (!$h) $h = new HttpMaker(); 
    return $h; 
}

// [2] 기존 코드와의 호환성을 위한 숏컷
if (!function_exists('http')) {
    function http() { return http_pq(); }
}

class HttpMaker {
    private $url, $params = [];

    // 🕵️‍♂️ [보안 수사대 1호] 전역 변수 세탁
    public function safe() {
        foreach ($_GET as $k => $v) {
            if (is_string($v)) $_GET[$k] = pq_clean($v); 
        }
        foreach ($_POST as $k => $v) {
            if (is_string($v)) $_POST[$k] = pq_clean($v);
        }
        if (class_exists('Trace')) {
            Trace::add('SECURITY', 'Global Input Sanitized (XSS Protected)');
        }
        return $this;
    }

    // 🕵️‍♂️ [보안 수사대 2호] 필수 입력값 검문소
    public function required($fields = []) {
        $missing = [];
        // 인자가 배열이 아닌 단일 문자열로 들어올 경우 처리
        if (is_string($fields)) $fields = explode(',', str_replace(' ', '', $fields));
        
        foreach ($fields as $f) {
            if (empty($_REQUEST[$f])) {
                $missing[] = $f;
            }
        }

        if (!empty($missing)) {
            $msg = implode(', ', $missing);
            if (class_exists('Trace')) Trace::add('ERROR', "Required Field Missing: [$msg]");
            die("<div style='padding:20px; border:2px solid red; background:#fff5f5; color:#c00;'>
                ❌ <b>[보안 수사대]</b> 필수 데이터( <b>$msg</b> )가 누락되어 작업을 중단합니다.
                </div>");
        }
        return $this;
    }

    // 🕵️‍♂️ [경로 수사대] 즉시 이동 기능
    public function redirect($u) {
        if (!headers_sent()) {
            // 🚨 [핵심] 브라우저 캐시를 완전히 무력화하여 뒤로가기 시 재검증 강제
            header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
            header("Pragma: no-cache"); // HTTP 1.0
            header("Expires: 0"); // Proxies
            
            header("Location: $u");
            exit;
        } else {
            // 이미 출력이 시작된 경우 JS로 흔적을 지우며 이동
            echo "<script>
                location.replace('$u'); // 히스토리를 덮어써서 뒤로가기 방지
            </script>";
            exit;
        }
    }
    

    public function get($k) { return $_GET[$k] ?? ''; }
    public function post($k) { return $_POST[$k] ?? ''; }

    public function url($u) {
        $u = str_replace('->', '.', $u);
        $this->url = trim($u, " \t\n\r\0\x0B\"'");
        return $this;
    }
}
?>
