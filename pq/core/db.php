<?php
/**
 * PQ DBMaker Core (v1.0)
 * [복구] 17개 핵심 수사 장비(함수) 통합 완료
 */

class DBMaker implements IteratorAggregate {
    private $conn = null;
    public $table = '', $wheres = [], $joins = [], $order = '', $fields = '*', $limit = '';
    private $pending_sql = ''; 

    // 1. [연결] connect() - DB 본부 접속
    public function connect() {
        if ($this->conn) return $this;
        global $_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME;
        
        // 지침 제1원칙: 설정 파일부터 수색
        $cfg_path = $_SERVER['DOCUMENT_ROOT'] . "/set/cfg_db.php";
        if (file_exists($cfg_path)) include_once $cfg_path;

        $this->conn = @mysqli_connect($_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME);
        if (!$this->conn) die("❌ [본부 연결 실패] " . mysqli_connect_error());
        mysqli_set_charset($this->conn, "utf8mb4");
        return $this;
    }

    // [초기화] 예약어 호출 시 작동
    function __get($name) { 
        $this->table = $name; 
        $this->wheres = []; $this->joins = []; $this->order = ''; $this->fields = '*'; $this->limit = '';
        $this->pending_sql = ''; 
        return $this; 
    }

    // 2. [직접 수사] query() - 생쿼리 실행용
    function query($sql) { $this->pending_sql = $sql; return $this; }

    // 3. [조건] where() & 17. [검색] like()
    function where($w, $v = null) { 
        if ($v !== null) $this->wheres[] = "`$w` = '" . $this->escape($v) . "'";
        elseif (is_array($w)) foreach($w as $k => $val) $this->wheres[] = "`$k` = '" . $this->escape($val) . "'";
        elseif ($w) $this->wheres[] = $w; 
        return $this; 
    }
    function like($f, $v) {
        if (!empty($v)) $this->wheres[] = "`$f` LIKE '%" . $this->escape($v) . "%'";
        return $this;
    }

    // 4. [삽입] insert()
    function insert($data) {
        $cols = []; $vals = [];
        foreach ($data as $k => $v) { $cols[] = "`$k`"; $vals[] = "'" . $this->escape($v) . "'"; }
        $this->pending_sql = "INSERT INTO `{$this->table}` (".implode(',', $cols).") VALUES (".implode(',', $vals).")";
        $res = $this->execute_pending();
        return $res ? mysqli_insert_id($this->conn) : false;
    }

    // 5. [갱신] update() & 6. [제거] delete()
    function update($data) {
        if (empty($this->wheres)) die("❌ [보안] where 없는 업데이트 차단");
        $sets = [];
        foreach ($data as $k => $v) $sets[] = "`$k` = '" . $this->escape($v) . "'";
        $this->pending_sql = "UPDATE `{$this->table}` SET ".implode(', ', $sets)." WHERE ".implode(" AND ", $this->wheres);
        return $this->execute_pending();
    }
    function delete() {
        if (empty($this->wheres)) die("❌ [보안] where 없는 삭제 차단");
        $this->pending_sql = "DELETE FROM `{$this->table}` WHERE " . implode(" AND ", $this->wheres);
        return $this->execute_pending();
    }

    // 7. [정렬] sort() & 8. [범위] limit()
    function sort($s, $d = "DESC") { $this->order = "$s $d"; return $this; }
    function limit($count, $start = null) {
        $this->limit = ($start === null) ? (int)$count : (int)$start . ", " . (int)$count;
        return $this;
    }

    // 9. [단건] one() & 10. [수량] cnt()
    function one() { $this->limit(1); foreach($this as $row) return $row; return null; }
    function cnt() {
        $sql = "SELECT COUNT(*) as cnt FROM `{$this->table}`" . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "");
        $this->connect();
        $res = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($res);
        return (int)($row['cnt'] ?? 0);
    }

    // 11. [존재확인] has()
    function has() {
        $this->connect();
        $res = mysqli_query($this->conn, "SHOW TABLES LIKE '{$this->table}'");
        return ($res && mysqli_num_rows($res) > 0);
    }

    // 12. [현장구축] make()
    function make($schema_file = null) {
        $path = $_SERVER['DOCUMENT_ROOT'] . "/set/" . ($schema_file ?? $this->table . ".sql");
        if (!file_exists($path)) return false;
        $queries = array_filter(explode(';', file_get_contents($path)));
        $this->connect();
        foreach ($queries as $q) if (trim($q)) mysqli_query($this->conn, $q);
        return true;
    }

    // 13. [청소] clear()
    function clear() { return $this->query("TRUNCATE TABLE `{$this->table}`")->execute_pending(); }

    // 14. [결합] join()
    function join($t, $c, $type = "INNER") { $this->joins[] = " $type JOIN `$t` ON $c"; return $this; }

    // 15. [추출] pluck()
    function pluck($field) {
        $list = []; foreach($this as $row) $list[] = $row->$field;
        return $list;
    }

    // 16. [조건부 가동] when()
    function when($cond, $callback) { if ($cond) $callback($this, $cond); return $this; }

    // [내부 엔진]
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
        if (class_exists('Trace')) Trace::add('SQL', $this->pending_sql); // 제2원칙: 수사견 연동
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
?>
