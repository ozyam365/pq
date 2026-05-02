<?php
/**
 * PQ DBMaker Core (v1.0)
 * [핵심] 체이닝 수사, 자동 연결, 지능형 카운트 결착
 */

class DBMaker {
    private $conn = null;
    public $table = '', $wheres = [], $joins = [], $order = '', $fields = '*', $limit = '';

    // 1. [잠복 연결] 필요한 순간에만 연결을 시도합니다.
    private function connect() {
        if ($this->conn) return $this;
        
        global $_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME;
        // 설정값 수사 (cfg_db.php 기반)
        $this->conn = @mysqli_connect($_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME);
        
        if (!$this->conn) {
            die("❌ [DB 수사 실패] 본부와의 연결이 끊겼습니다: " . mysqli_connect_error());
        }
        
        mysqli_set_charset($this->conn, "utf8mb4");
        return $this;
    }

    // 2. [타겟 지정] db.table 문법의 핵심
    function __get($name) { 
        $this->table = $name; 
        $this->wheres = []; $this->joins = []; 
        $this->order = ''; $this->fields = '*'; $this->limit = ''; 
        return $this; 
    }

    // 3. [수사망 구축]
    function where($w) { if($w) $this->wheres[] = $w; return $this; }
    function sort($s)  { $this->order = $s; return $this; }
    function field($f) { $this->fields = $f; return $this; }

    // 4. [명령 집행]
    function query($sql) {
        $this->connect();
        Trace::add('SQL', $sql); // 수사 기록 기록

        // 디버그 모드 시 화면에 쿼리 노출
        if (isset($GLOBALS['PQ_DEBUG_ON']) && $GLOBALS['PQ_DEBUG_ON']) {
            echo "<div style='background:#1a1a1a; color:#ffca28; padding:8px; border-left:4px solid #ffca28; font-size:12px; font-family:monospace;'>🔍 [SQL] $sql</div>";
        }
        
        return mysqli_query($this->conn, $sql);
    }

    // 5. [단일 타격] 용의자 1명만 즉시 검거
    function one() {
        $sql = "SELECT {$this->fields} FROM {$this->table}" 
             . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "") 
             . " LIMIT 1";
        $res = $this->query($sql);
        $row = ($res) ? mysqli_fetch_assoc($res) : null;
        return $row ? (object)$row : null;
    }

    // 6. [숫자 수사] 현재 수사망에 걸린 인원 파악
    function cnt() {
        $sql = "SELECT COUNT(*) as cnt FROM {$this->table}" 
             . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "");
        $res = $this->query($sql);
        $row = ($res) ? mysqli_fetch_assoc($res) : ['cnt' => 0];
        return (int)$row['cnt'];
    }

    // 7. [ID 추적] 방금 검거한 용의자 번호 낚아채기
    function id() {
        $this->connect();
        return mysqli_insert_id($this->conn);
    }

    // 8. [대량 소탕] 리스트 및 페이징 수사
    function all($p=1, $s=10) {
        $offset = ((int)$p - 1) * (int)$s;
        $sql = "SELECT {$this->fields} FROM {$this->table}" 
             . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "") 
             . ($this->order ? " ORDER BY ".$this->order : "") 
             . " LIMIT $offset, $s";
        
        $res = $this->query($sql);
        $list = [];
        while ($res && $row = mysqli_fetch_assoc($res)) $list[] = (object)$row;
        return $list;
    }

    // 9. [정보 갱신/투입]
    function insert($data) {
        $cols = []; $vals = [];
        foreach ($data as $k => $v) {
            $cols[] = "`$k`";
            $vals[] = "'" . mysqli_real_escape_string($this->connect()->conn, $v) . "'";
        }
        return $this->query("INSERT INTO {$this->table} (".implode(',', $cols).") VALUES (".implode(',', $vals).")");
    }
}
?>