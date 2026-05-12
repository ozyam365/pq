<?php
/**
 * PQ Form Manager (v1.1.3)
 * [수사 종결] util.php와 함수 중복 충돌 해결 및 하이브리드 get() 완비
 * [보안 보강] 필터링 기능 강화 및 세션 보안 수사 적용
 */

class FormMaker {
    private $data = [];
    private $errors = [];
    private $is_failed = false;

    public function __construct() {
        // 1. 현 시간부로 유입된 모든 용의자(POST/GET) 확보
        $this->data = array_merge($_GET, $_POST);
        
        // 2. 수사 실패를 대비하여 현재 진술(입력값)을 세션에 임시 보관 (세션 활성화 시)
        if (session_id()) {
            $_SESSION['_pq_old'] = $this->data;
        }
    }

    // 🕵️ [전량 검거] 수집된 모든 데이터 반환
    public function all() {
        return (object)$this->data;
    }

    // 🕵️ [하이브리드 검거] 인자가 있으면 단일 키 반환, 없으면 객체 반환
    public function get($k = null) {
        if ($k === null) return (object)$this->data;
        return $this->data[$k] ?? null;
    }

    // 🕵️ [골라내기] 특정 용의자만 수사망에 남김 (배열/문자열 모두 대응)
    public function only($keys = []) {
        if (is_string($keys)) $keys = explode(',', $keys);
        $new_data = [];
        foreach ($keys as $k) {
            $k = trim($k);
            if (isset($this->data[$k])) $new_data[$k] = $this->data[$k];
        }
        $this->data = $new_data;
        return $this;
    }

    // 🕵️ [제외하기] 불필요한 인원 방면
    public function except($keys = []) {
        if (is_string($keys)) $keys = explode(',', $keys);
        foreach ($keys as $k) {
            unset($this->data[trim($k)]);
        }
        return $this;
    }

    // 🕵️ [정돈] 불필요한 공백 제거 (재귀적 처리)
    public function trim() {
        array_walk_recursive($this->data, function(&$val) {
            if (is_string($val)) $val = trim($val);
        });
        return $this;
    }

    // 🕵️ [세탁] XSS 등 유해 성분 소독 (수사 지침 제4원칙 준수)
    public function safe() {
        array_walk_recursive($this->data, function(&$val) {
            if (is_string($val)) {
                $val = function_exists('pq_clean') ? pq_clean($val) : htmlspecialchars(strip_tags($val), ENT_QUOTES, 'UTF-8');
            }
        });
        return $this;
    }

    // 🕵️ [증거 조작] 임의로 데이터 설정
    public function set($k, $v) {
        $this->data[$k] = $v;
        return $this;
    }

    // 🕵️ [취조] 필수 항목 존재 여부 체크
    public function required($keys = []) {
        if (is_string($keys)) $keys = explode(',', $keys);
        foreach ($keys as $k) {
            $k = trim($k);
            if (!isset($this->data[$k]) || (is_string($this->data[$k]) && trim($this->data[$k]) === '')) {
                $this->errors[$k] = "REQUIRED_MISSING";
                $this->is_failed = true;
            }
        }
        return $this;
    }

    public function fail() { return $this->is_failed; }
    public function errors() { return $this->errors; }
    
    // 이전 진술 복구
    public function old($key, $default = "") { 
        return $_SESSION['_pq_old'][$key] ?? $default; 
    }
    
    public function clearOld() { 
        if (isset($_SESSION['_pq_old'])) unset($_SESSION['_pq_old']); 
        return $this; 
    }
}

/**
 * 🕵️ [중복 선언 방지] util.php와의 마찰 최소화
 */
if (!function_exists('form_pq')) {
    function form_pq() {
        static $f = null;
        if (!$f) $f = new FormMaker();
        return $f;
    }
}

if (!function_exists('form')) {
    function form() { return form_pq(); }
}
?>