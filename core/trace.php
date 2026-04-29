<?php
class Trace {

    public static $logs = [];
    private static $count = 0;
    private static $start = null;

    // 🔥 로그 추가
    static function add($type, $msg) {

        if (!self::$start) {
            self::$start = microtime(true);
        }

        self::$count++;

        self::$logs[] = [
            'no'   => self::$count,
            'type' => $type,
            'msg'  => $msg,
            'time' => microtime(true),
            // 🔥 성능: 호출 위치 1단계만
            'trace'=> debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0] ?? []
        ];
    }

    // 🔥 출력
    static function dump() {

        if (empty(self::$logs)) return;

        self::render_style();

        echo "<div class='pq-trace'>";
        echo "<div class='pq-title'>⚡ PQ TRACE</div>";

        foreach (self::$logs as $log) {

            $t = number_format(($log['time'] - self::$start), 6);
            $color = self::get_color($log['type']);

            echo "<div class='pq-item'>";

            echo "<span class='pq-meta'>#{$log['no']}</span> ";
            echo "<b style='color:{$color}'>[{$log['type']}]</b> ";
            echo "<span class='pq-meta'>+{$t}s</span>";

            $msg = htmlspecialchars($log['msg']);

            // 🔥 SQL만 강조 (성능)
            if ($log['type'] === 'SQL') {
                $msg = preg_replace(
                    '/\b(SELECT|FROM|WHERE|AND|OR|JOIN|ORDER\s+BY|LIMIT|INSERT|UPDATE|DELETE|VALUES|SET)\b/i',
                    '<span class="pq-sql-key">$1</span>',
                    $msg
                );
            }

            echo "<div class='pq-sql'>{$msg}</div>";

            // 🔥 위치 표시 (안전)
            if (!empty($log['trace']['file'])) {
                echo "<div class='pq-file'>";
                echo $log['trace']['file'] . ":" . $log['trace']['line'];
                echo "</div>";
            }

            echo "</div>";
        }

        echo "</div>";
    }

    // 🔥 타입별 색상
    private static function get_color($type) {
        return [
            'SQL'    => '#22c55e',
            'ERROR'  => '#ef4444',
            'OK'     => '#3b82f6',
            'ROWS'   => '#eab308',
            'AFFECT' => '#a78bfa',
            'DB'     => '#38bdf8'
        ][$type] ?? '#94a3b8';
    }

    // 🔥 스타일 (1회 출력)
    private static function render_style() {

        echo "<style>
            .pq-trace {
                font-family: Consolas, monospace;
                font-size:13px;
                background:#0f172a;
                color:#e2e8f0;
                padding:14px;
                border-radius:10px;
                margin-top:20px;
            }
            .pq-title {
                color:#38bdf8;
                font-weight:bold;
                margin-bottom:10px;
            }
            .pq-item {
                margin-bottom:10px;
                padding-bottom:6px;
                border-bottom:1px solid #1e293b;
            }
            .pq-meta {
                color:#64748b;
            }
            .pq-sql {
                margin-left:10px;
                color:#e2e8f0;
                white-space: pre-wrap;
                word-break: break-all;
            }
            .pq-file {
                margin-left:10px;
                color:#475569;
                font-size:11px;
            }
            .pq-sql-key {
                color:#38bdf8;
                font-weight:bold;
            }
        </style>";
    }
}
?>