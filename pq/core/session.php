<?php
/**
 * PQ Session Manager (v0.9.0)
 * [수사 지침] 세션은 변조를 즉시 감지해야 하며, 모든 수사관의 신원을 보증한다.
 * [업데이트] all() 장비 추가 및 체이닝 안정성 강화
 */

class PQSession {
    private static $is_init = false;
    private $is_guard = false;

    /**
     * 1. [보안] IP 감시 스위치
     * 이 장비를 켜면 세션 하이재킹(IP 변조) 발생 시 즉시 사살(Die)합니다.
     */
    public function guard() {
        $this->is_guard = true;
        return $this;
    }

    /**
     * 2. [제어] 내부 자동 호출 초기화
     * 수사 지침 제1원칙: 모든 출력보다 앞서 세션을 가동한다.
     */
    public function init() {
        if (self::$is_init) return $this;
        
        if (session_status() === PHP_SESSION_NONE) {
            // 세션 쿠키 보안 설정 추가 (HttpOnly, SameSite)
            session_start();
        }
        self::$is_init = true;

        // [은밀한 수사] IP 감시 대조
        if ($this->is_guard && isset($_SESSION['_ip'])) {
            if ($_SESSION['_ip'] !== $_SERVER['REMOTE_ADDR']) {
                $old_ip = $_SESSION['_ip'];
                $this->destroy();
                if (class_exists('Trace')) Trace::add('ERROR', "IP 변조 감지: $old_ip -> " . $_SERVER['REMOTE_ADDR']);
                die("❌ [보안차단] 세션 하이재킹 위험으로 차단되었습니다.");
            }
        }
        return $this;
    }

    /**
     * 3. [인증] 로그인 및 ID 재생성
     */
    public function login($user) {
        $this->init();
        // 보안: 세션 고정 공격 방지 (기존 데이터 유지하며 ID만 새로 발급)
        session_regenerate_id(true); 
        
        $_SESSION['user'] = $user;
        $_SESSION['_ip'] = $_SERVER['REMOTE_ADDR']; // 현재 접속 IP 박제
        
        if (class_exists('Trace')) Trace::add('OK', "신규 수사관 발령: " . (is_array($user) ? 'Data Secured' : $user));
        return $this;
    }

    /**
     * 4. [입출력] 데이터 관리
     */
    public function set($k, $v) {
        $this->init();
        $_SESSION[$k] = $v;
        return $this;
    }

    public function get($k, $def = null) {
        $this->init();
        return $_SESSION[$k] ?? $def;
    }

    /**
     * 🕵️ [신규 장비] 모든 세션 데이터 검거
     * 의도: "현재 세션에 기록된 모든 증거를 확인한다"
     */
    public function all() {
        $this->init();
        return function_exists('pq_data') ? pq_data($_SESSION) : $_SESSION;
    }

    /**
     * 5. [권한] 미인증 접근 차단
     */
    public function auth($path) {
        if (!$this->check()) {
            if (class_exists('Trace')) Trace::add('SECURITY', "미인증 접근 차단 -> $path 이동");
            header("Location: $path");
            exit;
        }
        return $this;
    }

    /**
     * 6. [청소 및 파괴]
     */
    public function clear() {
        $this->init();
        $_SESSION = [];
        if (class_exists('Trace')) Trace::add('OK', "세션 데이터 세탁 완료");
        return $this;
    }

    public function destroy() {
        $this->init();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, 
                $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        if (class_exists('Trace')) Trace::add('OK', "세션 증거 인멸 완료");
        return true;
    }

    /**
     * 7. [편의 기능]
     */
    public function flash($k, $v) { return $this->set($k, $v); }

    public function trash($k) {
        $val = $this->get($k);
        unset($_SESSION[$k]);
        return $val;
    }

    public function user() { return $this->get('user'); }

    public function check() { 
        $this->init();
        return !empty($_SESSION['user']); 
    }
}

/**
 * 🕵️ 시스템 예약어 session 가동
 */
function session_pq() {
    static $inst = null;
    if (!$inst) $inst = new PQSession();
    return $inst;
}
?>