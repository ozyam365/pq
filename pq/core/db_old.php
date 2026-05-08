<?php
/**
 * PQ DBMaker Core (v0.8.9)
 * [완전체] insert, update, delete 복구 및 when, has, pluck 등 17개 핵심 기능 통합
 */

class DBMaker implements IteratorAggregate {
    private $conn = null;
    public $table = '', $wheres = [], $joins = [], $order = '', $fields = '*', $limit = '';
    private $pending_sql = ''; 

    // 1. [연결] connect()
    private function connect() {
        if ($this->conn) return $this;
        global $_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME;
        $this->conn = @mysqli_connect($_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME);
        if (!$this->conn) die("❌ [본부 연결 실패] " . mysqli_connect_error());
        mysqli_set_charset($this->conn, "utf8mb4");
        return $this;
    }

    // [시작] 테이블 지정 및 초기화
    function __get($name) { 
        $this->table = $name; 
        $this->wheres = []; $this->joins = []; 
        $this->order = ''; $this->fields = '*'; $this->limit = '';
        $this->pending_sql = ''; 
        return $this; 
    }

    // 2. [직접 수사] query()
    function query($sql) { $this->pending_sql = $sql; return $this; }

    // 3. [조건] where() & 4. [검색] like()
    function where($w, $v = null) { 
        if ($v !== null) $this->wheres[] = "`$w` = '" . $this->escape($v) . "'";
        elseif ($w) $this->wheres[] = $w; 
        return $this; 
    }
    function like($f, $v) {
        if (!empty($v)) $this->wheres[] = "`$f` LIKE '%" . $this->escape($v) . "%'";
        return $this;
    }

    // 5. [정렬] sort() & 6. [범위] limit()
    function sort($s, $d = "DESC") { $this->order = "$s $d"; return $this; }
    function limit($count, $start = null) {
        $this->limit = ($start === null) ? (int)$count : (int)$start . ", " . (int)$count;
        return $this;
    }

    // 7. [결합] join()
    function join($t, $c, $type = "INNER") { $this->joins[] = " $type JOIN `$t` ON $c"; return $this; }

    // 8. [조건부 수사] when()
    function when($cond, $callback) { if ($cond) $callback($this, $cond); return $this; }

    // 9. [집행] insert()
    function insert($data) {
        $cols = []; $vals = [];
        foreach ($data as $k => $v) { $cols[] = "`$k`"; $vals[] = "'" . $this->escape($v) . "'"; }
        $this->pending_sql = "INSERT INTO `{$this->table}` (".implode(',', $cols).") VALUES (".implode(',', $vals).")";
        return $this->execute_pending() ? mysqli_insert_id($this->conn) : false;
    }

    // 10. [갱신] update()
    function update($data) {
        if (empty($this->wheres)) die("❌ [보안차단] where() 없는 업데이트 불가");
        $sets = [];
        foreach ($data as $k => $v) { $sets[] = "`$k` = '" . $this->escape($v) . "'"; }
        $this->pending_sql = "UPDATE `{$this->table}` SET " . implode(', ', $sets) . " WHERE " . implode(" AND ", $this->wheres);
        return $this->execute_pending() ? mysqli_affected_rows($this->conn) : false;
    }

    // 11. [제거] delete()
    function delete() {
        if (empty($this->wheres)) die("❌ [보안차단] where() 없는 삭제 불가");
        $this->pending_sql = "DELETE FROM `{$this->table}` WHERE " . implode(" AND ", $this->wheres);
        return $this->execute_pending() ? mysqli_affected_rows($this->conn) : false;
    }

    // 12. [단건] one() & 13. [수량] cnt()
    function one() { $this->limit(1); foreach($this as $row) return $row; return null; }
    function cnt() {
        $sql = "SELECT COUNT(*) as cnt FROM `{$this->table}`" . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "");
        $this->connect();
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return (int)($row['cnt'] ?? 0);
    }

    // 14. [추출] pluck()
    function pluck($field) {
        $list = [];
        foreach($this as $row) { $list[] = $row->$field; }
        return $list;
    }

    // 15. [존재확인] has()
    function has() {
        $this->connect();
        $res = mysqli_query($this->conn, "SHOW TABLES LIKE '{$this->table}'");
        return ($res && mysqli_num_rows($res) > 0);
    }

    // 16. [현장구축] make()
    function make($schema_file = null) {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/set/" . ($schema_file ?? $this->table . ".sql");
        if (!file_exists($path)) return "🔍 설계도 없음";
        $queries = array_filter(array_map('trim', explode(';', file_get_contents($path))));
        foreach ($queries as $q) { if ($q) { $this->connect(); mysqli_query($this->conn, $q); } }
        return "✅ 구축 완료";
    }

    // 17. [청소] clear()
    function clear() { return $this->query("TRUNCATE TABLE `{$this->table}`")->execute_pending(); }

    // [내부 엔진] 실행 및 반복
    private function escape($v) { $this->connect(); return mysqli_real_escape_string($this->conn, $v); }
    
    private function execute_pending() {
        if (empty($this->pending_sql)) {
            $this->pending_sql = "SELECT {$this->fields} FROM `{$this->table}`" 
                . ($this->joins ? implode(" ", $this->joins) : "") 
                . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "") 
                . ($this->order ? " ORDER BY ".$this->order : "") 
                . ($this->limit ? " LIMIT ".$this->limit : "");
        }
        $this->connect();
        if (class_exists('Trace')) Trace::add('SQL', $this->pending_sql);
        $res = mysqli_query($this->conn, $this->pending_sql);
        $this->pending_sql = ''; 
        return $res;
    }

    public function getIterator(): Traversable {
        $res = $this->execute_pending();
        while ($res && $row = mysqli_fetch_assoc($res)) yield (object)$row;
    }
}

function db() { static $i; if (!$i) $i = new DBMaker(); return $i; }