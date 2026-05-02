<?php
/**
 * PQ Session Manager (v0.8.7)
 * [수사 지침] 세션은 모든 출력보다 앞서야 하며, 누락을 허용하지 않는다.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class PQSession {
    public function __get($key) {
        return $_SESSION[$key] ?? null;
    }

    public function __set($key, $val) {
        $_SESSION[$key] = $val;
    }

    public function clear() {
        session_unset();
        session_destroy();
    }
}

function session_pq() {
    static $inst = null;
    if (!$inst) $inst = new PQSession();
    return $inst;
}
?>