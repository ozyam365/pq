<?php
class DBBuilder {

    private $table;
    private $joins = [];
    private $wheres = [];

    public function __construct($table) {
        $this->table = $table;
    }

    public function join($table, $on) {
        $this->joins[] = "JOIN $table ON $on";
        return $this;
    }

    public function where($field, $op, $value) {

        // 값 안전 처리 (간단 버전)
        if (is_string($value)) {
            $value = "'" . addslashes($value) . "'";
        }

        $this->wheres[] = "$field $op $value";
        return $this;
    }

    public function get() {

        DB::con();

        $sql = "SELECT * FROM {$this->table}";

        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }

        if (!empty($this->wheres)) {
            $sql .= " WHERE " . implode(" AND ", $this->wheres);
        }

        return DB::query($sql);
    }
}
?>