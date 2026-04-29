<?php
function db() {
    static $db = null;
    if (!$db) $db = new DBMaker();
    return $db;
}

class DBMaker {
    public $table = '', $wheres = [], $joins = [], $order = '', $fields = '*', $limit = '';
    private $conn = null;

    // 1. 접속 및 설정
    function connect($h=null, $u=null, $p=null, $n=null) {
        global $_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME;
        $h = $h ?? $_SQL_HOST;
        $u = $u ?? $_SQL_USER;
        $p = $p ?? $_SQL_PASS;
        $n = $n ?? $_SQL_NAME;

        $this->conn = @mysqli_connect($h, $u, $p, $n);
        if (!$this->conn) Trace::add('ERROR', 'DB Connect Fail');
        else { 
            mysqli_set_charset($this->conn, "utf8mb4"); 
            Trace::add('DB', 'Connected'); 
        }
        return $this;
    }

    // 2. [헌법] db.user.where() 형태를 지원하는 매직 메서드
    function __get($name) {
        $this->table = $name;
        // 새 쿼리 시작 시 빌더 초기화
        $this->wheres = []; $this->joins = []; $this->order = ''; $this->fields = '*'; $this->limit = '';
        return $this;
    }

    // 3. 쿼리 빌더 (Chaining)
    function tbl($t)   { $this->table = $t; return $this; }
    function field($f) { $this->fields = $f; return $this; }
    function join($j)  { $this->joins[] = "JOIN ".$j; return $this; }
    function sort($s)  { $this->order = $s; return $this; }
    function where($w) { if($w) $this->wheres[] = $w; return $this; }
    function and($w)   { return $this->where($w); }

    // 4. [헌법] Lazy 실행 트리거 (호출 시점에 build_sql 실행)
    function build_sql() {
        $sql = "SELECT {$this->fields} FROM {$this->table}";
        if ($this->joins)  $sql .= " " . implode(" ", $this->joins);
        if ($this->wheres) $sql .= " WHERE " . implode(" AND ", $this->wheres);
        if ($this->order)  $sql .= " ORDER BY " . $this->order;
        if ($this->limit)  $sql .= " LIMIT " . $this->limit;
        return $sql;
    }
	function query($sql) {
		// 만약 연결이 없으면 자동으로 기본 연결 시도 (안전 장치)
		if (!$this->conn) $this->connect(); 
		
		Trace::add('SQL', $sql);
		$res = mysqli_query($this->conn, $sql);
		if (!$res) Trace::add('ERROR', mysqli_error($this->conn));
		return $res;
	}
	function one() {
		$this->limit = "1";
		$res = $this->query($this->build_sql());
		
		// 헌법 5조: 마침표(.) 접근을 위해 object로 반환
		$row = $res ? mysqli_fetch_assoc($res) : null;
		return $row ? (object)$row : null;
	}
    function cnt() {
        $old_fields = $this->fields; $this->fields = "COUNT(*) as cnt";
        $sql = $this->build_sql();
        $res = $this->query($sql);
        $this->fields = $old_fields; // 상태 복구
        return $res ? (int)mysqli_fetch_assoc($res)['cnt'] : 0;
    }

    function limit($p, $s) {
        $total = $this->cnt();
        $offset = ((int)$p - 1) * (int)$s;
        $this->limit = "$offset, $s";
        $res = $this->query($this->build_sql());
        return ['total' => $total, 'page' => (int)$p, 'size' => (int)$s, 'rows' => $res];
    }

    function pluck($column) {
        $res = $this->query($this->build_sql());
        $list = [];
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) $list[] = $row[$column] ?? null;
        }
        return $list;
    }

    // 6. 데이터 조작 (CUD)
    function insert($data) {
        if (!$this->conn) return false;
        if (is_string($data)) $data = json_decode($data, true);
        if (!is_array($data) || empty($data)) return false;

        $keys = array_keys($data);
        $vals = array_map(function($v) {
            if ($v === null) return "NULL";
            return "'" . mysqli_real_escape_string($this->conn, $v) . "'";
        }, array_values($data));

        $sql = "INSERT INTO {$this->table} (" . implode(",", $keys) . ") VALUES (" . implode(",", $vals) . ")";
        $res = $this->query($sql);
        if ($res) Trace::add('OK', 'Insert Success ID: ' . mysqli_insert_id($this->conn));
        return $res;
    }

    function update($data) {
        if (empty($this->wheres)) { Trace::add('ERROR', 'UPDATE denied: No WHERE'); return false; }
        $sets = [];
        foreach ($data as $k => $v) {
            $v = mysqli_real_escape_string($this->conn, $v);
            $sets[] = "`$k` = '$v'";
        }
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE " . implode(' AND ', $this->wheres);
        return $this->query($sql);
    }

    function delete() {
        if (empty($this->wheres)) { Trace::add('ERROR', 'DELETE denied: No WHERE'); return false; }
        $sql = "DELETE FROM {$this->table} WHERE " . implode(' AND ', $this->wheres);
        return $this->query($sql);
    }

}
?>