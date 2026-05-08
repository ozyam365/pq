<?php
/**
 * PQ HTTP Manager (v0.9.0)
 * [수사 지침] timeout() 수사 속도 조절 및 all() 데이터 통합 검거 장비 완비
 * [업데이트] form.all()과의 공조를 위한 원천 데이터 제공 기능 확정
 */

class HttpMaker {
    private $url = "";
    private $method = "GET";
    private $headers = [];
    private $params = [];
    private $timeout = 5; // 기본 수사 속도 5초
    private $body = null;

    // 🕵️ [기본 수사] GET, POST, PUT, DELETE
    public function get($url) { return $this->send($url, "GET"); }
    public function post($url, $data = []) { $this->params = $data; return $this->send($url, "POST"); }
    public function put($url, $data = []) { $this->params = $data; return $this->send($url, "PUT"); }
    public function delete($url) { return $this->send($url, "DELETE"); }

    public function header($text) { $this->headers[] = $text; return $this; }
    
    // 🕵️ [속도 조절] 수사 시간 제한 (timeout)
    public function timeout($sec) { 
        $this->timeout = (int)$sec; 
        return $this; 
    }
    
    public function json($data) {
        $this->header('Content-Type: application/json');
        $this->body = json_encode($data);
        return $this;
    }

    /**
     * 🕵️ [신규 장비] 모든 요청 데이터를 PQData로 반환
     * 의도: "통신 레벨에서 들어온 모든 파라미터를 검거한다"
     */
    public function all() {
        // GET과 POST를 통합 수집 (제1원칙: 누락 없는 수사)
        $data = array_merge($_GET, $_POST);
        return function_exists('pq_data') ? pq_data($data) : $data;
    }

    private function send($url, $method) {
        $this->url = $url;
        $this->method = $method;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if (!empty($this->headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        if ($this->body !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);
        elseif (!empty($this->params)) curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->params));

        $res = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            if (class_exists('Trace')) Trace::add('ERROR', "HTTP 수사 실패: $err");
            // 실패해도 빈 PQData를 반환하여 후속 체이닝을 보호함 (제2원칙)
            return function_exists('pq_data') ? pq_data([]) : [];
        }

        return $this->parse_response($res);
    }

    private function parse_response($res) {
        $json = json_decode($res, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return function_exists('pq_data') ? pq_data($json) : $json;
        }
        return $res;
    }

    /**
     * 🕵️ [보안 장비] 데이터 세탁 (Safe)
     */
    public function safe() {
        // 전역 변수를 직접 세탁하여 보안 사고 방지
        foreach ($_GET as $k => $v) if (is_string($v)) $_GET[$k] = function_exists('pq_clean') ? pq_clean($v) : $v;
        foreach ($_POST as $k => $v) if (is_string($v)) $_POST[$k] = function_exists('pq_clean') ? pq_clean($v) : $v;
        return $this;
    }

    /**
     * 🕵️ [현장 이동] 리다이렉트
     */
    public function redirect($u) {
        if (!headers_sent()) { header("Location: $u"); exit; }
        echo "<script>location.replace('$u');</script>"; exit;
    }
}

// 🕵️ 예약어 http 가동
function http_pq() { 
    static $h = null; 
    if (!$h) $h = new HttpMaker(); 
    return $h; 
}

if (!function_exists('http')) {
    function http() { return http_pq(); }
}
?>
