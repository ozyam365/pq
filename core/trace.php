<?php
// 상태 변수
$__TRACE = false;
$__TRACE_FORCE = false;
$__TRACE_ERROR = false;
$__TRACE_LOG = [];

class Trace {

    private static $startTime = 0;

    /**
     * 🔥 TRACE ON
     */
    public static function on() {
        global $__TRACE, $__TRACE_FORCE;
        $__TRACE = true;
        $__TRACE_FORCE = true;
    }

    /**
     * 🔥 TRACE OFF
     */
    public static function off() {
        global $__TRACE;
        $__TRACE = false;
    }

    /**
     * 🔥 전체 시간 시작
     */
    public static function start() {
        self::$startTime = microtime(true);
    }

    /**
     * 🔥 라인 + 실행시간
     */
    public static function timeLine($i, $line, $time) {
        global $__TRACE, $__TRACE_LOG;

        if ($__TRACE) {
            $__TRACE_LOG[] =
                ">> " . ($i+1) . ": " . $line .
                " (" . number_format($time, 5) . "s)";
        }
    }

    /**
     * 🔥 SQL 로그
     */
    public static function sql($sql, $time) {
        global $__TRACE, $__TRACE_LOG;

        if ($__TRACE) {
            $__TRACE_LOG[] = "🧠 SQL: " . $sql;
            $__TRACE_LOG[] = "⏱ SQL: " . number_format($time, 5) . "s";
        }
    }

    /**
     * 🔥 OK
     */
    public static function ok() {
        global $__TRACE, $__TRACE_LOG;

        if ($__TRACE) {
            $__TRACE_LOG[] = "✔ ok";
        }
    }

    /**
     * 🔥 ERROR
     */
    public static function error($msg) {
        global $__TRACE, $__TRACE_ERROR, $__TRACE_LOG;

        $__TRACE = true;
        $__TRACE_ERROR = true;

        $__TRACE_LOG[] = "❌ error: " . $msg;
    }

    /**
     * 🔥 종료 시간
     */
    private static function end() {
        $end = microtime(true);
        $time = $end - self::$startTime;

        echo "⏱ TOTAL: " . number_format($time, 5) . "s" . nl();
    }
    /**
     * 🔥HTTP
     */
	public static function http($url, $time) {
		global $__TRACE, $__TRACE_LOG;

		if ($__TRACE) {
			$__TRACE_LOG[] = "🌐 HTTP: " . $url;
			$__TRACE_LOG[] = "⏱ HTTP: " . number_format($time, 5) . "s";
		}
	}
    /**
     * 🔥 출력
     */
	 public static function output() {
		global $__TRACE_FORCE, $__TRACE_ERROR, $__TRACE_LOG;

		if (!$__TRACE_FORCE && !$__TRACE_ERROR) return;

		// 🔥 RESULT 먼저 출력
		Msg::output();

		echo "---- TRACE START ----" . nl();

		foreach ($__TRACE_LOG as $log) {
			echo $log . nl();
		}

		echo "---- TRACE END ----" . nl();

		self::end();
	}
}
?>