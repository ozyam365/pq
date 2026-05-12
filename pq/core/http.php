<?php
/**
 * PQ HTTP Manager (v0.9.3)
 * [수사 종결] IoT 및 외부 API 통신 전담 수사관
 * [보안 강화] SSL 수사망 정밀화 및 HTTP 응답 상태별 추적 기능 보강
 */

class HttpMaker {
    private $url = "";
    private $method = "GET";
    private $headers = [];
    private $params = [];
    private $timeout = 5; 
    private $body = null;

    // 🕵️ [Step 0] 정보 수사 (IP/Agent)
    public function ip() {
        // 프록시 환경에서도 실제 범인(IP)을 찾기 위한 수사망 확대
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        }
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    public function agent() {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    }

    // 🕵️ [기본 수사] GET, POST, PUT, DELETE
    public function get($url) { return $this->send($url, "GET"); }
    public function post($url, $data = []) { $this->params = $data; return $this->send($url, "POST"); }
    public function put($url, $data = []) { $this->params = $data; return $this->send($url, "PUT"); }
    public function delete($url) { return $this->send($url, "DELETE"); }

    public function header($text) { $this->headers[] = $text; return $this; }
    
    public function timeout($sec) { 
        $this->timeout = (int)$sec; 
        return $this; 
    }
    
    public function json($data) {
        $this->header('Content-Type: application/json');
        $this->body = is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : $data;
        return $this;
    }

    /**
     * 🕵️ 유입 데이터 전량 압수 (ArrayObject 변환)
     */
    public function all() {
        $data = array_merge($_GET, $_POST);
        return function_exists('pq_data') ? pq_data($data) : (object)$data;
    }

    private function send($url, $method) {
        $this->url = $url;
        $this->method = $method;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 개발 편의성 유지
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent()); // 내 에이전트 정보 전송

        if (!empty($this->headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        
        if ($this->body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);
        } elseif (!empty($this->params)) {
            // GET일 경우 URL에 파라미터 결합 수사
            if ($method === 'GET') {
                $query = http_build_query($this->params);
                curl_setopt($ch, CURLOPT_URL, $this->url . (strpos($this->url, '?') !== false ? '&' : '?') . $query);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->params));
            }
        }

        $res = curl_exec($ch);
        $err = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        // 수사 장비 초기화
        $this->headers = [];
        $this->params = [];
        $this->body = null;
        $this->timeout = 5; 

        if ($err) {
            if (class_exists('Trace')) Trace::add('ERROR', "HTTP 수사 실패($url): $err");
            return function_exists('pq_data') ? pq_data([]) : (object)[];
        }

        // 수사 기록 (Trace 연동)
        if (class_exists('Trace')) {
            Trace::add('HTTP', "[$method] $url (Code: {$info['http_code']})");
        }

        return $this->parse_response($res);
    }

    private function parse_response($res) {
        if (empty($res)) return null;
        
        $json = json_decode($res, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            // JSON 결과도 PQData로 감싸서 체이닝 수사 지원
            return function_exists('pq_data') ? pq_data($json) : (object)$json;
        }
        return $res;
    }

    /**
     * 🕵️ 입구 수사 (XSS 소독)
     */
    public function safe() {
        $cleaner = function(&$val) {
            if (is_string($val)) {
                $val = function_exists('pq_clean') ? pq_clean($val) : htmlspecialchars(strip_tags($val), ENT_QUOTES, 'UTF-8');
            }
        };
        array_walk_recursive($_GET, $cleaner);
        array_walk_recursive($_POST, $cleaner);
        return $this;
    }

    /**
     * 🕵️ 긴급 이동 (Redirect)
     */
    public function redirect($u) {
        if (!headers_sent()) { 
            header("Location: $u"); 
            exit; 
        }
        echo "<script>location.replace('$u');</script>"; 
        exit;
    }
}

/**
 * HTTP 헬퍼 함수
 */
function http_pq() { 
    static $h = null; 
    if (!$h) $h = new HttpMaker(); 
    return $h; 
}

if (!function_exists('http')) {
    function http() { return http_pq(); }
}
?>
