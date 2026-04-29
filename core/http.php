<?php
function http() { static $h = null; if (!$h) $h = new HttpMaker(); return $h; }
class HttpMaker {
    private $url, $params = [];

    function get($k) { return $_GET[$k] ?? ''; }
    function post($k) { return $_POST[$k] ?? ''; }


	function url($u) {
		// 1. 모든 화살표를 마침표로 강제 복구
		$u = str_replace('->', '.', $u);
		// 2. 따옴표 및 공백 제거
		$this->url = trim($u, " \t\n\r\0\x0B\"'");
		Trace::add('HTTP_URL', "FINAL_CHECK: [" . $this->url . "]");
		return $this;
	}

	function send($method = 'GET') {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // 리다이렉트 추적
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);    // 레퍼러 자동 생성
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		
		// 코인베이스가 좋아하는 브라우저 헤더
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36');

		$res = curl_exec($ch);
		curl_close($ch);

		$json = json_decode($res, false);
		return (json_last_error() === JSON_ERROR_NONE) ? $json : $res;
	}

    function param($p) { $this->params = $p; return $this; }
}
?>