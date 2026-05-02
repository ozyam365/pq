<?php
// /pq/core/http.php

function http() { static $h = null; if (!$h) $h = new HttpMaker(); return $h; }

// [핵심 수사 지점] 이 함수가 정의되어 있어야 합니다!
if (!function_exists('http')) {
    function http() { 
        static $h = null; 
        if (!$h) $h = new HttpMaker(); 
        return $h; 
    }
}

class HttpMaker {
    private $url, $params = [];

	// /pq/core/http.php 내 safe() 함수
	function safe() {
		// 🕵️‍♂️ [보안 지침] 전역 변수 $_GET, $_POST를 직접 세탁합니다.
		foreach ($_GET as $k => $v) {
			if (is_string($v)) $_GET[$k] = pq_clean($v); 
		}
		foreach ($_POST as $k => $v) {
			if (is_string($v)) $_POST[$k] = pq_clean($v);
		}
		Trace::add('SECURITY', 'Global Input Sanitized (XSS Protected)');
		return $this;
	}


    // [보안 수사대 2호] 필수 입력값 검문소
    function required($fields = []) {
        $missing = [];
        foreach ($fields as $f) {
            // GET/POST 어디에도 값이 없으면 범인으로 간주
            if (empty($_REQUEST[$f])) {
                $missing[] = $f;
            }
        }

        if (!empty($missing)) {
            $msg = implode(', ', $missing);
            Trace::add('ERROR', "Required Field Missing: [$msg]");
            // 수사 지침 제5조: 에러 날 상황이면 여기서 즉시 집행 중단
            die("❌ <b>[보안 수사대]</b> 필수 데이터( $msg )가 누락되어 작업을 중단합니다.");
        }
        return $this;
    }

    function get($k) { return $_GET[$k] ?? ''; }
    function post($k) { return $_POST[$k] ?? ''; }

    // (기존 url, send, param 함수 유지...)
    function url($u) {
        $u = str_replace('->', '.', $u);
        $this->url = trim($u, " \t\n\r\0\x0B\"'");
        return $this;
    }
}
?>