<?php
/**
 * PQ DBMaker Core (v0.7.9)
 * [업데이트] 대기 변수(Lazy) 구현 및 update() 결과 최적화
 */

class DBMaker implements IteratorAggregate {
    private $conn = null;
    public $table = '', $wheres = [], $joins = [], $order = '', $fields = '*', $limit = '';
    private $pending_sql = ''; // 대기 중인 쿼리 저장소

    private function connect() {
        if ($this->conn) return $this;
        global $_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME;
        $this->conn = @mysqli_connect($_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME);
        if (!$this->conn) die("❌ [DB 수사 실패] 본부 연결 불가: " . mysqli_connect_error());
        mysqli_set_charset($this->conn, "utf8mb4");
        return $this;
    }

    function __get($name) { 
        $this->table = $name; 
        $this->wheres = []; $this->joins = []; 
        $this->order = ''; $this->fields = '*'; $this->limit = '';
        $this->pending_sql = ''; // 타겟 변경 시 대기 쿼리 초기화
        return $this; 
    }

    function where($w) { if($w) $this->wheres[] = $w; return $this; }
    function sort($s)  { $this->order = $s; return $this; }
    function field($f) { $this->fields = $f; return $this; }
    function limit($count, $start = null) {
        $this->limit = ($start === null) ? (int)$count : (int)$start . ", " . (int)$count;
        return $this;
    }

    // [개정] query()는 즉시 실행하지 않고 '대기 변수' 상태로 객체를 반환합니다.
    function query($sql) {
        $this->pending_sql = $sql;
        return $this; // 대기 변수(@res)로서 자기 자신을 반환
    }

    // [핵심] 실제 실행이 필요한 순간(foreach 등)에만 작동하는 수사 집행관
    private function execute_pending() {
        if (empty($this->pending_sql)) {
            // 체이닝 기반 SQL 자동 생성
            $this->pending_sql = "SELECT {$this->fields} FROM `{$this->table}`" 
                 . ($this->joins ? implode(" ", $this->joins) : "") 
                 . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "") 
                 . ($this->order ? " ORDER BY ".$this->order : "") 
                 . ($this->limit ? " LIMIT ".$this->limit : "");
        }

        $this->connect();
        if (class_exists('Trace')) Trace::add('SQL', $this->pending_sql);
        
        $res = mysqli_query($this->conn, $this->pending_sql);
        $this->pending_sql = ''; // 실행 후 비움
        return $res;
    }

    // [트리거] foreach 진입 시 실체화
    public function getIterator(): Traversable {
        $res = $this->execute_pending();
        while ($res && $row = mysqli_fetch_assoc($res)) {
            yield (object)$row;
        }
    }

    // [트리거] 단일 수사 시 실체화
    function one() {
        $this->limit(1);
        foreach($this as $row) return $row;
        return null;
    }

    function cnt() {
        $this->pending_sql = "SELECT COUNT(*) as cnt FROM `{$this->table}`" 
             . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "");
        $res = $this->execute_pending();
        $row = mysqli_fetch_assoc($res);
        return (int)($row['cnt'] ?? 0);
    }

    // [개정] 업데이트 성공 시 영향을 받은 행(Affected Rows)의 수를 즉시 반환
    function update($data) {
        if (empty($this->wheres)) die("❌ [보안차단] where() 없는 업데이트 불가");
        $sets = [];
        foreach ($data as $k => $v) {
            $sets[] = "`$k` = '" . mysqli_real_escape_string($this->connect()->conn, $v) . "'";
        }
        $this->pending_sql = "UPDATE `{$this->table}` SET " . implode(', ', $sets) . " WHERE " . implode(" AND ", $this->wheres);
        
        if ($this->execute_pending()) {
            return mysqli_affected_rows($this->conn); // 영향 받은 행 수 반환
        }
        return false;
    }

    function insert($data) {
        $cols = []; $vals = [];
        foreach ($data as $k => $v) {
            $cols[] = "`$k`";
            $vals[] = "'" . mysqli_real_escape_string($this->connect()->conn, $v) . "'";
        }
        $this->pending_sql = "INSERT INTO `{$this->table}` (".implode(',', $cols).") VALUES (".implode(',', $vals).")";
        return $this->execute_pending() ? mysqli_insert_id($this->conn) : false;
    }

    function delete() {
        if (empty($this->wheres)) die("❌ [보안차단] where() 없는 삭제 불가");
        $this->pending_sql = "DELETE FROM `{$this->table}` WHERE " . implode(" AND ", $this->wheres);
        if ($this->execute_pending()) {
            return mysqli_affected_rows($this->conn);
        }
        return false;
    }

	function pluck($field) {
		$list = [];
		// foreach 진입 시 getIterator()가 작동하며 DB 수사가 시작됩니다.
		foreach($this as $row) {
			$list[] = $row->$field; // 지정된 컬럼만 배열에 담기
		}
		return $list; // 1차원 배열 반환
	}
    // [트리거] DB 수사와 메모리 수사의 연결점
    function filter($callback) {
        // 1. 아직 실행 전인 대기 쿼리가 있다면 즉시 실행(Trigger)하여 리스트 확보
        $list = [];
        foreach($this as $row) {
            $list[] = $row;
        }

        // 2. 확보된 리스트를 바탕으로 콜백 수사 진행
        $filtered = [];
        foreach ($list as $item) {
            if ($callback($item)) {
                $filtered[] = $item;
            }
        }

        // 3. 결과 반환 (이후 다시 체이닝이 가능하도록 필요시 객체화)
        return $filtered;
    }
    function yn() {
        $this->connect();
        // SHOW TABLES 문법을 사용하여 테이블이 있는지 물리적으로 확인
        $res = mysqli_query($this->conn, "SHOW TABLES LIKE '{$this->table}'");
        
        // 테이블이 하나라도 검색되면 true, 아니면 false
        return ($res && mysqli_num_rows($res) > 0);
    }
    /**
     * 10. [현장 구축] 설계도(.sql)를 읽어 테이블 생성
     * @usage: db.users.make("users.sql")
     */
    function make($schema_file = null) {
        // 파일명이 없으면 테이블명.sql로 자동 지정
        $filename = $schema_file ?? $this->table . ".sql";
        $path = $_SERVER['DOCUMENT_ROOT'] . "/set/" . $filename;
        
        if (!file_exists($path)) {
            return "🔍 [설계도 미확보] {$path} 파일이 없습니다.";
        }

        $sql = file_get_contents($path);
        // 세미콜론 기준으로 쿼리 분할 (다중 테이블/인덱스 생성 대응)
        $queries = array_filter(array_map('trim', explode(';', $sql)));
        
        foreach ($queries as $q) {
            if ($q) {
                $this->connect();
                mysqli_query($this->conn, $q);
            }
        }
        return "✅ [현장 구축 완료] {$this->table} 테이블 생성됨";
    }
	function clear() {
		// 보안상 테이블명이 확실할 때만 작동
		if (!$this->table) return "❌ [ 중단] 타겟 테이블이 지정되지 않았습니다.";
		return $this->query("TRUNCATE TABLE `{$this->table}`");
	}
    // 이 블록이 파일 안에 딱 하나만 있어야 합니다.
    function join($target, $cond, $type = "INNER") {
        $this->joins[] = " {$type} JOIN `{$target}` ON {$cond}";
        return $this;
    }
}

function db() { static $i; if (!$i) $i = new DBMaker(); return $i; }
?>