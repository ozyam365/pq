<?php
function db() { static $db = null; if (!$db) $db = new DBMaker(); return $db; }
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