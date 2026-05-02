<?php
function db() {
    static $pdo;
    if (!$pdo) {
        // 🔍 [수사 포인트] 기존 설정 파일을 읽어와 변수를 확보합니다.
        include_once $_SERVER['DOCUMENT_ROOT'] . "/set/cfg_db.php";

        try {
            // cfg_db.php에 설정된 변수명을 사용하십시오 (변수명이 다르면 수정 필요)
            $pdo = new PDO(
                "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", 
                $db_user, 
                $db_pass, 
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );
        } catch (PDOException $e) {
            die("❌ DB 수사 실패: " . $e->getMessage());
        }
    }
    return $pdo;
}

// (@user) = db_one(...) 문법을 위한 실전 함수
function db_one($query, $params = []) {
    $stmt = db()->prepare($query);
    $stmt->execute($params);
    return $stmt->fetch();
}
class DBMaker {
    public $table = '', $wheres = [], $joins = [], $order = '', $fields = '*', $limit = '';
    private $conn = null;

    function connect() {
        global $_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME;
        $this->conn = @mysqli_connect($_SQL_HOST, $_SQL_USER, $_SQL_PASS, $_SQL_NAME);
        if ($this->conn) mysqli_set_charset($this->conn, "utf8mb4");
        Trace::add('DB', $this->conn ? 'Connected' : 'Connect Fail');
        return $this;
    }

    function __get($name) { 
        $this->table = $name; $this->wheres = []; $this->joins = []; 
        $this->order = ''; $this->fields = '*'; $this->limit = ''; 
        return $this; 
    }

    function where($w) { if($w) $this->wheres[] = $w; return $this; }
    function sort($s)  { $this->order = $s; return $this; }
    
    function query($sql) {
        if (!$this->conn) $this->connect();
        Trace::add('SQL', $sql);
        if (isset($GLOBALS['PQ_DEBUG_ON']) && $GLOBALS['PQ_DEBUG_ON']) {
            echo "<div style='background:#1a1a1a; color:#ffca28; padding:5px; border-left:4px solid #ffca28; font-size:12px;'>🔍 [SQL_LOG] $sql</div>";
        }
        return mysqli_query($this->conn, $sql);
    }

    function one() {
        $this->limit = "1";
        $res = $this->query("SELECT {$this->fields} FROM {$this->table}" . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "") . " LIMIT 1");
        $row = $res ? mysqli_fetch_assoc($res) : null;
        return $row ? (object)$row : null;
    }

    function limit($p, $s) {
        $offset = ((int)$p - 1) * (int)$s;
        $this->limit = "$offset, $s";
        $sql = "SELECT {$this->fields} FROM {$this->table}" . ($this->wheres ? " WHERE ".implode(" AND ", $this->wheres) : "") . ($this->order ? " ORDER BY ".$this->order : "") . " LIMIT {$this->limit}";
        $res = $this->query($sql);
        $list = [];
        while ($res && $row = mysqli_fetch_assoc($res)) $list[] = (object)$row;
        return (object)['rows' => pq_data($list)];
    }

    function update($data) {
        if (empty($this->wheres)) return false;
        $sets = []; foreach ($data as $k => $v) $sets[] = "`$k` = '".mysqli_real_escape_string($this->conn, $v)."'";
        return $this->query("UPDATE {$this->table} SET ".implode(', ', $sets)." WHERE ".implode(' AND ', $this->wheres));
    }
}
?>