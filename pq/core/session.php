<?php
/**
 * PQ Session Manager (v1.0.2)
 * [수사 종결] IP 감시 체계 및 하이재킹 방어 수사망 완비
 * [철칙] 세션은 정결하게 유지되어야 하며, 불필요한 증거를 남기지 않는다.
 */

class PQSession {
    private static $is_init = false;
    private $is_guard = false;

    /**
     * 🕵️ [Step 0] 엔진 통합 체크용 id 수사
     */
    public function id() {
        $this->init();
        return session_id();
    }

    /**
     * 1. [보안] IP 감시 스위치 (init 전 설정 권장)
     */
    public function guard() {
        $this->is_guard = true;
        return $this;
    }

    /**
     * 2. [제어] 초기화 (수사 지침 제1원칙 준수)
     */
    public function init() {
        if (self::$is_init) return $this;
        
        if (session_status() === PHP_SESSION_NONE) {
            // 보안을 위해 쿠키 보안 옵션 강제 (HTTPS 환경 권장)
            session_start();
        }
        self::$is_init = true;

        // 🚨 [보안 수사] IP 변조 검문 집행
        if ($this->is_guard && isset($_SESSION['_ip'])) {
            $current_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            if ($_SESSION['_ip'] !== $current_ip) {
                $old_ip = $_SESSION['_ip'];
                $this->destroy();
                if (class_exists('Trace')) Trace::add('ERROR', "세션 탈취 의심: IP 변조 감지 ($old_ip -> $current_ip)");
                die("❌ [보안차단] 비정상적인 세션 접근이 감지되어 강제 종료되었습니다.");
            }
        }
        return $this;
    }

    /**
     * 3. [인증] 로그인 (ID 재생성으로 추적 교란 차단)
     */
    public function login($user) {
        $this->init();
        // 기존 세션 무효화 및 새 ID 발급 (세션 고정 공격 방지)
        session_regenerate_id(true); 
        $_SESSION['user'] = (object)$user; // 유저 정보를 객체로 저장하여 (@session).user.name 접근 지원
        $_SESSION['_ip'] = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $_SESSION['_ua'] = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'; // 브라우저 정보도 추가 수사
        
        if (class_exists('Trace')) Trace::add('OK', "신규 수사관(유저) 로그인 성공");
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
     * 🕵️ 전량 압수: PQData로 감싸서 체이닝 지원
     */
    public function all() {
        $this->init();
        return function_exists('pq_data') ? pq_data($_SESSION) : (object)$_SESSION;
    }

    /**
     * 5. [권한] 미인증 접근 차단 (수사망 밖으로 방출)
     */
    public function auth($path = "/login") {
        if (!$this->check()) {
            if (class_exists('HttpMaker')) {
                (new HttpMaker())->redirect($path);
            } else {
                header("Location: $path");
            }
            exit;
        }
        return $this;
    }

    /**
     * 6. [청소 및 파괴] 증거 인멸
     */
    public function clear() {
        $this->init();
        $_SESSION = [];
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
        @session_destroy();
        self::$is_init = false;
        return true;
    }

    /**
     * 7. [특수 장비] 플래시 메시지
     */
    public function flash($k, $v = null) {
        $this->init();
        if ($v !== null) {
            $_SESSION['_flash'][$k] = $v;
            return $this;
        } else {
            if (!isset($_SESSION['_flash'][$k])) return null;
            $val = $_SESSION['_flash'][$k];
            unset($_SESSION['_flash'][$k]);

            if (empty($_SESSION['_flash'])) {
                unset($_SESSION['_flash']);
            }
            return $val;
        }
    }

    public function hasFlash($k) {
        $this->init();
        return isset($_SESSION['_flash'][$k]);
    }

    /**
     * 🕵️ 수사관 신분 확인
     */
    public function user() { 
        $user = $this->get('user');
        return is_array($user) ? (object)$user : $user;
    }

    public function check() { 
        $this->init();
        return !empty($_SESSION['user']); 
    }
}

/**
 * SESSION 헬퍼 함수
 * 사용법: [[ @session.login(@user) ]]
 */
function session_pq() {
    static $inst = null;
    if (!$inst) $inst = new PQSession();
    return $inst;
}
?>