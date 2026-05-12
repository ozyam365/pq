<?php
/**
 * PQ DBMaker Core (v1.2.2)
 * [수사 종결] Iterator 기반 자동 수사망 및 지능형 에스케이프 적용
 * [보안 강화] WHERE 절 없는 위험 수사(CUD) 원천 차단
 */

class DBMaker implements IteratorAggregate {
    private $conn = null;
    public $table = '', $wheres = [], $joins = [], $order = '', $fields = '*', $limit = '';
    private $pending_sql = ''; 

    // 🕵️ [Step 0] 엔진 통합 체크용 ping
    public function ping() {
        try {
            $this->connect();
            return ($this->conn && mysqli_ping($this->conn));
        } catch (Exception $e) {
            return false;
        }
    }

    // 1. [연결] 본부와의 보안 채널 구축
    public function connect() {
        if ($this->conn) return $this;
        global $_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME;
        
        $cfg_path = $_SERVER['DOCUMENT_ROOT'] . "/set/cfg_db.php";
        if (file_exists($cfg_path)) include_once $cfg_path;

        // @를 붙여 연결 실패 시 PHP 자체 경고를 숨기고 PQ Trace로 관리
        $this->conn = @mysqli_connect($_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME);
        if (!$this->conn) {
            $err = mysqli_connect_error();
            if (class_exists('Trace')) Trace::add('ERROR', "DB 연결 실패: $err");
            die("❌ [본부 연결 실패] 수사 중단: $err");
        }
        mysqli_set_charset($this->conn, "utf8mb4");
        return $this;
    }

    // [기폭제] 테이블 호출 시 초기화 - 새 사건 수사 시작
    function __get($name) { 
        $this->table = $name; 
        $this->wheres = []; 
        $this->joins = []; 
        $this->order = ''; 
        $this->fields = '*'; 
        $this->limit = '';
        $this->pending_sql = ''; 
        return $this; 
    }

    // 2. [직접 수사] query()
    function query($sql) { $this->pending_sql = $sql; return $this; }

    // 3. [조건] where() - 지능형 필터링
    function where($w, $v = null) { 
        if ($v !== null) $this->wheres[] = (empty($this->wheres) ? "" : "AND ") . "`$w` = '" . $this->escape($v) . "'";
        elseif (is_array($w)) {
            foreach($w as $k => $val) {
                $this->wheres[] = (empty($this->wheres) ? "" : "AND ") . "`$k` = '" . $this->escape($val) . "'";
            }
        }
        elseif ($w) $this->wheres[] = (empty($this->wheres) ? "" : "AND ") . $w; 
        return $this; 
    }

    function and($w, $v = null) { return $this->where($w, $v); }

    function or($w, $v = null) {
        if (empty($this->wheres)) return $this->where($w, $v);
        $clause = ($v !== null) ? "`$w` = '" . $this->escape($v) . "'" : $w;
        $this->wheres[] = "OR " . $clause;
        return $this;
    }

    // 4. [검색] like()
    function like($f, $v) {
        if (!empty($v)) $this->wheres[] = (empty($this->wheres) ? "" : "AND ") . "`$f` LIKE '%" . $this->escape($v) . "%'";
        return $this;
    }

    // 5~6. [정렬/범위]
    function sort($s, $d = "DESC") { $this->order = "$s $d"; return $this; }
    function limit($count, $start = null) {
        $this->limit = ($start === null) ? (int)$count : (int)$start . ", " . (int)$count;
        return $this;
    }

    // 7. [결합] join()
    function join($t, $c, $type = "INNER") { $this->joins[] = " $type JOIN `$t` ON $c"; return $this; }

    // 8. [조건부] when() - 동적 쿼리 수사에 탁월
    function when($cond, $callback) { if ($cond) $callback($this, $cond); return $this; }

    // 9~11. [CUD 집행] 
    function insert($data) {
        $cols = []; $vals = [];
        foreach ($data as $k => $v) { $cols[] = "`$k`"; $vals[] = "'" . $this->escape($v) . "'"; }
        $this->pending_sql = "INSERT INTO `{$this->table}` (".implode(',', $cols).") VALUES (".implode(',', $vals).")";
        return $this->execute_pending() ? mysqli_insert_id($this->conn) : false;
    }

    function update($data) {
        if (empty($this->wheres)) die("❌ [보안 지침 제1조 위반] WHERE 없는 업데이트는 금지됩니다.");
        $sets = [];
        foreach ($data as $k => $v) $sets[] = "`$k` = '" . $this->escape($v) . "'";
        $w = $this->build_where();
        $this->pending_sql = "UPDATE `{$this->table}` SET ".implode(', ', $sets)." WHERE " . $w;
        return $this->execute_pending();
    }

    function delete() {
        if (empty($this->wheres)) die("❌ [보안 지침 제1조 위반] WHERE 없는 삭제는 금지됩니다.");
        $w = $this->build_where();
        $this->pending_sql = "DELETE FROM `{$this->table}` WHERE " . $w;
        return $this->execute_pending();
    }

    // 12~13. [단건/수량]
    function one() { $this->limit(1); foreach($this as $row) return $row; return null; }
    function cnt() {
        $w = $this->build_where();
        $sql = "SELECT COUNT(*) as cnt FROM `{$this->table}`" . ($w ? " WHERE " . $w : "");
        $this->connect();
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return (int)($row['cnt'] ?? 0);
    }

    // 14. [추출] pluck() - 특정 필드만 배열로 압수
    function pluck($field) { $list = []; foreach($this as $row) { $list[] = $row->{$field} ?? null; } return $list; }

    // 15~17. [테이블 관리]
    function has() {
        $this->connect();
        $res = mysqli_query($this->conn, "SHOW TABLES LIKE '{$this->table}'");
        return ($res && mysqli_num_rows($res) > 0);
    }
    function make($schema_file = null) {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/set/" . ($schema_file ?? $this->table . ".sql");
        if (!file_exists($path)) return false;
        $queries = array_filter(explode(';', file_get_contents($path)));
        $this->connect();
        foreach ($queries as $q) if (trim($q)) mysqli_query($this->conn, $q);
        return true;
    }
    function clear() { return $this->query("TRUNCATE TABLE `{$this->table}`")->execute_pending(); }

    // [내부 헬퍼] 수사망 구축
    private function build_where() {
        if (empty($this->wheres)) return "";
        $str = implode(" ", $this->wheres);
        $str = preg_replace('/^\s*(AND|OR)\s+/i', '', $str);
        return trim($str);
    }

    private function escape($v) { 
        if (is_null($v)) return "";
        $this->connect(); 
        return mysqli_real_escape_string($this->conn, $v); 
    }
    
    private function execute_pending() {
        if (empty($this->pending_sql)) {
            $w = $this->build_where();
            $this->pending_sql = "SELECT {$this->fields} FROM `{$this->table}`" 
                . ($this->joins ? implode(" ", $this->joins) : "") 
                . ($w ? " WHERE $w" : "") 
                . ($this->order ? " ORDER BY ".$this->order : "") 
                . ($this->limit ? " LIMIT ".$this->limit : "");
        }
        $this->connect();
        if (class_exists('Trace')) Trace::add('SQL', $this->pending_sql);
        $res = mysqli_query($this->conn, $this->pending_sql);
        $this->pending_sql = ''; 
        return $res;
    }

    // [핵심] 수사 대상 나열 (Traversable)
    public function getIterator(): Traversable {
        $res = $this->execute_pending();
        if (!$res) return new ArrayIterator([]);
        
        $rows = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $rows[] = (object)$row;
        }
        return new ArrayIterator($rows);
    }
}

/**
 * DB 헬퍼 함수
 * 사용법: [[ @list = db.users.where("level", 1).sort("idx"); ]]
 */
function db() { static $i; if (!$i) $i = new DBMaker(); return $i; }
?>
