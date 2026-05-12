<?php
/**
 * PQ Text Manager (v1.0.1)
 * [수사 종결] 읽기 쉬운 이름, 실무 위주의 텍스트 통합 수사관
 * [보강] 한글(UTF-8) 수사 정밀화 및 체이닝 연동 강화
 */

class PQText {
    // 1️⃣ 기본 변환 계열
    public function upper($s) { return mb_strtoupper((string)$s, 'UTF-8'); }
    public function lower($s) { return mb_strtolower((string)$s, 'UTF-8'); }
    public function trim($s)  { return trim((string)$s); }
    public function length($s) { return mb_strlen((string)$s, 'UTF-8'); }
    
    /**
     * 🕵️ 거꾸로 수사: 한글 깨짐 방지 로직 적용
     */
    public function reverse($s) {
        $r = '';
        $len = mb_strlen((string)$s, 'UTF-8');
        for ($i = $len - 1; $i >= 0; $i--) {
            $r .= mb_substr((string)$s, $i, 1, 'UTF-8');
        }
        return $r;
    }

    public function slice($s, $start, $len = null) { 
        return mb_substr((string)$s, $start, $len, 'UTF-8'); 
    }

    /**
     * 🕵️ 요약 수사: 말줄임표(...) 자동 생성
     */
    public function cut($s, $len = 100, $suffix = "...") {
        $s = (string)$s;
        if (mb_strlen($s, 'UTF-8') <= $len) return $s;
        return mb_substr($s, 0, $len, 'UTF-8') . $suffix;
    }

    // 2️⃣ 검색 계열
    public function contains($s, $needle) { return str_contains((string)$s, (string)$needle); }
    public function starts($s, $needle) { return str_starts_with((string)$s, (string)$needle); }
    public function ends($s, $needle) { return str_ends_with((string)$s, (string)$needle); }
    public function count($s, $needle) { return mb_substr_count((string)$s, (string)$needle, 'UTF-8'); }

    // 3️⃣ 수정 계열
    public function replace($s, $search, $replace) { return str_replace($search, $replace, (string)$s); }
    public function repeat($s, $n) { return str_repeat((string)$s, (int)$n); }
    
    // 한글 포함 시 글자 수 기준으로 패딩 처리
    public function padLeft($s, $len, $char = " ") {
        $s = (string)$s;
        $currentLen = mb_strlen($s, 'UTF-8');
        if ($currentLen >= $len) return $s;
        return str_repeat($char, $len - $currentLen) . $s;
    }
    
    public function padRight($s, $len, $char = " ") {
        $s = (string)$s;
        $currentLen = mb_strlen($s, 'UTF-8');
        if ($currentLen >= $len) return $s;
        return $s . str_repeat($char, $len - $currentLen);
    }

    // 4️⃣ 분리 / 결합 계열
    public function split($s, $delim = ",") { return explode($delim, (string)$s); }
    public function join($arr, $delim = ",") { return implode($delim, (array)$arr); }

    // 5️⃣ 검사 계열
    public function isEmpty($s) { return empty(trim((string)$s)); }
    public function isEmail($s) { return filter_var((string)$s, FILTER_VALIDATE_EMAIL) !== false; }
    public function isUrl($s) { return filter_var((string)$s, FILTER_VALIDATE_URL) !== false; }
    public function isJson($s) { 
        if (!is_string($s)) return false;
        json_decode($s); 
        return json_last_error() === JSON_ERROR_NONE; 
    }

    // 6️⃣ 포맷 계열
    public function slug($s) {
        $s = mb_strtolower((string)$s, 'UTF-8');
        // 한글, 영문, 숫자 유지 및 공백을 하이픈으로
        $s = preg_replace('/[^a-z0-9가-힣\s]/u', '', $s);
        return preg_replace('/\s+/', '-', trim($s));
    }
    public function capitalize($s) { return mb_convert_case((string)$s, MB_CASE_TITLE, "UTF-8"); }

    // 7️⃣ 웹 / 보안 계열
    public function escapeHtml($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
    public function stripTags($s) { return strip_tags((string)$s); }

    // 8️⃣ 생성 계열 (현장 조작 방지용 무작위 단서)
    public function random($len = 10) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, ceil($len/strlen($pool)))), 0, $len);
    }
    
    public function uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), 
            mt_rand(16384, 20479), mt_rand(32768, 49151), 
            mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)
        );
    }

    // 9️⃣ 템플릿 계열 (🔥 핵심 병기)
    public function format($tpl, $vars = []) {
        $vars = (array)$vars;
        foreach ($vars as $k => $v) {
            $tpl = str_replace("{".$k."}", (string)$v, (string)$tpl);
        }
        return $tpl;
    }
}

/**
 * 🕵️ TEXT 헬퍼 함수 가동
 * 사용법: [[= text.cut(@long_text, 50) ]]
 */
if (!function_exists('text_pq')) {
    function text_pq() {
        static $inst = null;
        if (!$inst) $inst = new PQText();
        return $inst;
    }
}
?>
