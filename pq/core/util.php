<?php
/**
 * PQ Utility Core (v0.8.8)
 */

class PQ_Util {
    private $val;
    public function __construct($v) { $this->val = $v; }
    public function filled() { return !empty(trim((string)$this->val)); }
    public function mark($w) {
        if (!$w) return $this;
        $this->val = str_replace($w, "<mark class='bg-warning'>$word</mark>", $this->val);
        return $this;
    }
    public function color($c, $match) {
        if ($this->val == $match) $this->val = "<span style='color:$c; font-weight:bold;'>{$this->val}</span>";
        return $this;
    }
    public function icon($type) {
        if (!$this->val) return $this;
        $cls = ($type == "image") ? "bi-image" : "bi-file-earmark";
        $this->val .= " <i class='bi $cls text-primary'></i>";
        return $this;
    }
    public function money() { if (is_numeric($this->val)) $this->val = number_format((float)$this->val); return $this; }
    public function hancut($l) { $this->val = mb_strimwidth($this->val, 0, $l, '..', 'UTF-8'); return $this; }
    public function __toString() { return (string)$this->val; }
}

// 🕵️ [통합 수사] 자동 라우팅 함수를 유틸로 완전히 이관
if (!function_exists('autoRoute')) {
    function autoRoute($dir, $prefix) {
        if (!is_dir($dir)) return;
        $items = glob($dir . '/*.pq');
        if (!$items) return;
        foreach ($items as $file) {
            $name = basename($file, '.pq');
            if (class_exists('PQRouter')) {
                PQRouter::set($prefix . '/' . $name, $file);
            }
        }
    }
}

class PQDate { public function __get($k) { return match($k){'now'=>date("Y-m-d"),'full'=>date("Y-m-d H:i:s"),'year'=>date("Y"),default=>date("Y-m-d H:i:s")}; } }
function date_pq() { static $i; if (!$i) $i = new PQDate(); return $i; }

class PQTime { public function __get($k) { return match($k){'stamp'=>time(),'hi'=>date("H:i"),default=>date("H:i:s")}; } }
function time_pq() { static $i; if (!$i) $i = new PQTime(); return $i; }

class PQForm {
    public function __get($k) { return isset($_REQUEST[$k]) ? pq_clean($_REQUEST[$k]) : null; }
    public function all() { return function_exists('pq_data') ? pq_data($_REQUEST) : $_REQUEST; }
}
function form_pq() { static $i; if (!$i) $i = new PQForm(); return $i; }
?>
