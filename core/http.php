<?php
class HttpResponse {
    private $body;

	public function __construct($body) {
        $this->body = $body;
    }

    public function json() {
        return json_decode($this->body, true);
    }

    public function text() {
        return $this->body;
    }

    public function __toString() {
        return (string)$this->body;
    }
}

class Http {

    public static function get($url, $timeout = 5) {

        $start = microtime(true);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0'
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        $time = microtime(true) - $start;

        Trace::http($url, $time);

        // 🔥 핵심: 객체 반환
        return new HttpResponse($response);
    }
}
?>