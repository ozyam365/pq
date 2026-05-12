<?php
/**
 * PQ Trace System (v1.2.2)
 * [수사 종결] 수사 보고서 디자인 고도화 및 다크모드 최적화
 * [철칙] 모든 수사 기록은 투명해야 하며, 범인(Error/SQL)을 끝까지 추적한다.
 */

class Trace {
    public static $logs = [];
    private static $count = 0;
    private static $start = null;
    private static $is_active = false;
    private static $rendered = false;
    private static $checkpoints = [];

    /**
     * 🔥 [제2원칙] 수사견 파견 (Trace On)
     */
    public static function on() {
        self::$is_active = true;
        self::$start = self::$start ?? microtime(true);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        self::add('OK', '🕵️ PQ Debugger Online - 수사망이 가동되었습니다.', 1);
    }

    /**
     * 🕵️ [장비 확인] 수사견 활성화 여부
     */
    public static function is_active() {
        return self::$is_active;
    }

    /**
     * 🕵️ [정밀 수색] 사건 기록
     */
    public static function add($type, $msg, $depth = 1) {
        if (!self::$is_active) return;
        if (!self::$start) self::$start = microtime(true);
        self::$count++;
        
        // 호출 위치 추적
        $bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $depth + 1);
        $caller = $bt[$depth] ?? $bt[0];
        $file = isset($caller['file']) ? basename($caller['file']) : 'unknown';
        $line = isset($caller['line']) ? $caller['line'] : '0';

        $msg_str = (is_scalar($msg)) ? (string)$msg : json_encode($msg, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        self::$logs[] = [
            'no'   => self::$count,
            'type' => $type,
            'msg'  => $msg_str,
            'time' => microtime(true),
            'file' => $file,
            'line' => $line
        ];

        // 긴급 에러 발생 시 즉각 현장 보고
        if ($type === 'ERROR') {
            echo "<div style='background:#450a0a; color:#fca5a5; padding:15px; border:2px solid #ef4444; margin:10px; font-family:monospace; border-radius:8px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.5);'>
                    <b style='color:#f87171;'>🚨 [긴급수사 위반]</b> $msg_str 
                    <div style='font-size:11px; margin-top:5px; color:#fca5a5; opacity:0.8;'>📍 현장: $file (Line: $line)</div>
                  </div>";
        }
    }

    public static function sql($query) { self::add('SQL', $query, 2); }

    /**
     * ⚡ [시간 수사] 성능 병목 구간 체포
     */
    public static function time($label = "Check") {
        $now = microtime(true);
        $base = self::$checkpoints[$label] ?? self::$start;
        $elapsed = number_format($now - $base, 4);
        $mem = number_format(memory_get_usage() / 1024 / 1024, 2) . "MB";
        self::add('TIME', "[$label] 소요시간: {$elapsed}s / 메모리: $mem", 1);
        self::$checkpoints[$label] = $now;
    }

    /**
     * 📦 [증거물 보존] 변수 덤프
     */
    public static function dump($var, $title = "증거물") {
        if (!self::$is_active) return;
        echo "<fieldset style='border:2px solid #38bdf8; padding:12px; margin:15px; background:#0f172a; color:#f1f5f9; border-radius:10px; font-family:Consolas, monospace; overflow:hidden;'>";
        echo "<legend style='font-weight:bold; color:#38bdf8; background:#1e293b; padding:2px 12px; border-radius:5px; border:1px solid #38bdf8;'>📦 $title</legend>";
        echo "<pre style='white-space:pre-wrap; margin:0; word-break:break-all; font-size:12px; color:#94a3b8;'>";
        ob_start();
        var_dump($var);
        echo htmlspecialchars(ob_get_clean());
        echo "</pre></fieldset>";
    }

    /**
     * 📊 [최종 보고] 수사 종결 보고서 출력
     */
    public static function out() {
        if (self::$rendered || !self::$is_active || empty(self::$logs)) return; 
        self::$rendered = true;
        self::render_style();
        
        echo "<div class='pq-trace-container'>";
        echo "<div class='pq-trace-header'>
                <span class='pq-trace-badge'>PQ INVESTIGATOR</span>
                <span class='pq-trace-title'>FINAL CASE REPORT</span>
                <span style='float:right; opacity:0.5;'>v1.2.2</span>
              </div>";

        foreach (self::$logs as $log) {
            $t = number_format(($log['time'] - self::$start), 4);
            $color = self::get_color($log['type']);
            echo "<div class='pq-trace-item' style='border-left: 4px solid $color;'>";
            echo "<div class='pq-trace-meta'>
                    <span class='pq-trace-no'>#{$log['no']}</span> 
                    <span class='pq-trace-type' style='color:{$color}'>{$log['type']}</span> 
                    <span class='pq-trace-time'>+{$t}s</span>
                  </div>";

            $msg = htmlspecialchars($log['msg']);
            if ($log['type'] === 'SQL') {
                $msg = preg_replace('/\b(SELECT|FROM|WHERE|AND|OR|JOIN|LEFT|INNER|ORDER\s+BY|LIMIT|INSERT|UPDATE|DELETE|VALUES|SET|GROUP\s+BY|HAVING)\b/i', '<span class="pq-sql-key">$1</span>', $msg);
            }
            
            echo "<div class='pq-trace-msg'>{$msg}</div>";
            echo "<div class='pq-trace-file'>📁 Source: {$log['file']} <span style='color:#38bdf8'>(Line: {$log['line']})</span></div>";
            echo "</div>";
        }
        echo "</div>";
    }

    private static function get_color($type) {
        $colors = ['SQL'=>'#22c55e', 'ERROR'=>'#ef4444', 'TIME'=>'#f59e0b', 'OK'=>'#3b82f6', 'DB'=>'#38bdf8', 'HTTP'=>'#a855f7', 'LIST'=>'#ec4899'];
        return $colors[$type] ?? '#94a3b8';
    }

    private static function render_style() {
        if (defined('PQ_STYLE_LOADED')) return;
        echo "<style>
            .pq-trace-container { font-family: 'Consolas', 'Monaco', monospace; font-size:13px; background:#0f172a; color:#e2e8f0; padding:20px; border-radius:15px; margin:30px 15px; border:1px solid #1e293b; clear:both; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5); position:relative; z-index:99999; }
            .pq-trace-header { border-bottom: 2px solid #1e293b; padding-bottom:15px; margin-bottom:20px; }
            .pq-trace-badge { background:#38bdf8; color:#0f172a; padding:2px 8px; border-radius:4px; font-weight:bold; font-size:10px; margin-right:10px; vertical-align:middle; }
            .pq-trace-title { font-size:16px; font-weight:bold; color:#f1f5f9; vertical-align:middle; letter-spacing:1px; }
            .pq-trace-item { background:#1e293b; margin-bottom:12px; padding:12px 15px; border-radius:0 8px 8px 0; transition: transform 0.2s; }
            .pq-trace-item:hover { background:#334155; transform: translateX(5px); }
            .pq-trace-meta { margin-bottom:8px; font-size:11px; }
            .pq-trace-no { color:#475569; margin-right:10px; }
            .pq-trace-type { font-weight:bold; margin-right:15px; }
            .pq-trace-time { color:#64748b; }
            .pq-trace-msg { color:#f1f5f9; white-space: pre-wrap; word-break: break-all; line-height:1.6; font-size:13px; }
            .pq-trace-file { margin-top:8px; color:#64748b; font-size:11px; border-top:1px solid #334155; padding-top:6px; }
            .pq-sql-key { color:#38bdf8; font-weight:bold; text-transform: uppercase; }
        </style>";
        define('PQ_STYLE_LOADED', true);
    }
}

/**
 * Trace 헬퍼 가동
 */
function trace($type, $msg) { Trace::add($type, $msg, 2); }

// 사령부 명령 대기열 등록
register_shutdown_function(['Trace', 'out']);
?>
