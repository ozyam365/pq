<?php
class PQData extends ArrayObject {
    public function __get($n) { return $this[$n] ?? null; }
    public function where($c) { return pq_where($this, $c); }
    public function pluck($f) { return pq_pluck($this, $f); }
    public function money() { return pq_money($this); }
    public function count(): int { return parent::count(); } 
}
function pq_data($a) { return new PQData((array)$a); }
function pq_money($v) { if($v instanceof PQData)$v=$v[0]; return is_numeric($v)?number_format((float)$v):$v; }
function pq_clean($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function pq_debug($m) { $GLOBALS['PQ_DEBUG_ON'] = ($m == "on"); }
function pq_print($v) { echo "<pre style='background:#f4f4f4; padding:10px;'>"; print_r($v); echo "</pre>"; }

function pq_where($arr, $cond) {
    if ($arr instanceof PQData) $arr = $arr->getArrayCopy();
    preg_match('/(\w+)\s*([><=]+)\s*(.*)/', trim((string)$cond, "\"' "), $m);
    if(!$m) return pq_data($arr);
    list(, $f, $op, $val) = $m; $val = trim($val, " '\"");
    $res = array_filter($arr, function($r) use ($f, $op, $val) {
        $r = (object)$r; $t = $r->$f ?? 0;
        return ($op == '>') ? $t > $val : (($op == '<') ? $t < $val : $t == $val);
    });
    return pq_data(array_values($res));
}
?>