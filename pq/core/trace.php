<?php
/**
 * PQ Trace System (v0.7-alpha)
 * 수사 지침 준수: 스위치가 켜질 때만 기록하고 출력한다.
 */

class Trace {
    public static $logs = [];
    private static $count = 0;
    private static $start = null;
    private static $is_active = false;

    // 🔥 수사 시작 스위치: trace.on() 호출 시 집행
    public static function on() {
        self::$is_active = true;
        if (!self::$start) {
            self::$start = microtime(true);
        }
        // [검수 포인트] 시작과 동시에 첫 번째 로그를 강제로 남깁니다.
        self::add('OK', 'Investigation Started (v0.7-alpha)');
    }

    // 🔥 스위치 상태 확인
    public static function is_active() {
        return self::$is_active;
    }

    // 🔥 로그 추가: 스위치가 켜져 있을 때만 기록
    public static function add($type, $msg) {
        // [지침 제2원칙] 스위치가 꺼져 있으면 기록하지 않는다.
        if (!self::$is_active) return;

        if (!self::$start) {
            self::$start = microtime(true);
        }

        self::$count++;
        
        // 호출 위치 추적
        $bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $file = isset($bt[0]['file']) ? basename($bt[0]['file']) : 'unknown';
        $line = isset($bt[0]['line']) ? $bt[0]['line'] : '0';

        self::$logs[] = [
            'no'   => self::$count,
            'type' => $type,
            'msg'  => $msg,
            'time' => microtime(true),
            'file' => $file,
            'line' => $line
        ];
    }

    // 🔥 최종 출력: run.php 하단에서 호출
    public static function out() {
        if (self::$is_active === false || empty(self::$logs)) {
            return; 
        }
        self::dump();
    }

    // 🔥 터미널 렌더링
    private static function dump() {
        self::render_style();

        echo "<div class='pq-trace'>";
        echo "<div class='pq-title'>⚡ PQ TRACE REPORT</div>";

        foreach (self::$logs as $log) {
            $t = number_format(($log['time'] - self::$start), 6);
            $color = self::get_color($log['type']);

            echo "<div class='pq-item'>";
            echo "<span class='pq-meta'>#{$log['no']}</span> ";
            echo "<b style='color:{$color}'>[{$log['type']}]</b> ";
            echo "<span class='pq-meta'>+{$t}s</span>";

            $msg = htmlspecialchars($log['msg']);

            // SQL 키워드 강조 (성능 최적화)
            if ($log['type'] === 'SQL') {
                $msg = preg_replace(
                    '/\b(SELECT|FROM|WHERE|AND|OR|JOIN|ORDER\s+BY|LIMIT|INSERT|UPDATE|DELETE|VALUES|SET)\b/i',
                    '<span class="pq-sql-key">$1</span>',
                    $msg
                );
            }

            echo "<div class='pq-sql'>{$msg}</div>";
            echo "<div class='pq-file'>Located: {$log['file']} (Line: {$log['line']})</div>";
            echo "</div>";
        }
        echo "</div>";
    }

    private static function get_color($type) {
        $colors = [
            'SQL'    => '#22c55e', 'ERROR'  => '#ef4444',
            'OK'     => '#3b82f6', 'ROWS'   => '#eab308',
            'AFFECT' => '#a78bfa', 'DB'     => '#38bdf8'
        ];
        return $colors[$type] ?? '#94a3b8';
    }

    private static function render_style() {
        echo "<style>
            .pq-trace { font-family: Consolas, monospace; font-size:13px; background:#0f172a; color:#e2e8f0; padding:18px; border-radius:12px; margin:20px; border:1px solid #1e293b; }
            .pq-title { color:#38bdf8; font-weight:bold; margin-bottom:15px; border-bottom:1px solid #334155; padding-bottom:10px; }
            .pq-item { margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #1e293b; }
            .pq-meta { color:#64748b; }
            .pq-sql { margin-left:10px; color:#f1f5f9; white-space: pre-wrap; word-break: break-all; margin-top:4px; }
            .pq-file { margin-left:10px; color:#475569; font-size:11px; margin-top:4px; font-style:italic; }
            .pq-sql-key { color:#38bdf8; font-weight:bold; }
        </style>";
    }
}
?>