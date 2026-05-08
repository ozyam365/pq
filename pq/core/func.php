<?php
/**
 * PQ Core Functions (v0.8.8)
 * [수사 지침] pagenavi() 메서드를 통해 현재 검색 조건을 유지한 채 URL을 자동 생성한다.
 */

class PQData extends ArrayObject {
    public function __get($n) { 
        return isset($this[$n]) ? $this[$n] : null; 
    }

    // 🕵️ [이름 확정] pagenavi: 현재 검색/필터 조건을 유지하며 특정 값만 교체한 URL 생성
    // 사용법: [[=(@req).pagenavi(['page' => 2])]]
    public function pagenavi($add = []) {
        $current = $this->getArrayCopy();
        
        // 1. 기존 데이터와 새로 들어온 데이터(예: page)를 합침
        $data = array_merge($current, $add);
        
        // 2. 값이 없는 불필요한 파라미터는 수사망에서 제외하여 URL을 깨끗하게 만듦
        $data = array_filter($data, function($v) { 
            return $v !== '' && $v !== null; 
        });

        // 3. 현재 파일 경로를 자동으로 파악 (PHP_SELF 활용)
        $target = $_SERVER['PHP_SELF'];
        
        return $target . "?" . http_build_query($data);
    }

    // 🕵️ 짧은 이름을 선호할 때를 위한 별칭 (Alias)
    public function url($add = []) { return $this->pagenavi($add); }

    public function filled($key = null) {
        $val = ($key === null) ? (string)$this : ($this[$key] ?? null);
        return !empty(trim((string)$val));
    }

    public function only(...$keys) {
        $res = [];
        foreach ($keys as $k) if ($this->offsetExists($k)) $res[$k] = $this[$k];
        return pq_data($res);
    }

    public function except(...$keys) {
        $res = $this->getArrayCopy();
        foreach ($keys as $k) unset($res[$k]);
        return pq_data($res);
    }

    public function has($key) { return $this->offsetExists($key); }
    public function where($c) { return pq_where($this, $c); }
    public function pluck($f) { return pq_pluck($this, $f); }
    public function join($glue = ', ') { return implode($glue, $this->getArrayCopy()); }
    public function count(): int { return parent::count(); }
    public function __toString() { return is_string($this->getArrayCopy()) ? $this->getArrayCopy() : ""; }
}

function pq_data($a) { return new PQData((array)$a); }
function pq_clean($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

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

function pq_pluck($arr, $field) {
    if ($arr instanceof PQData) $arr = $arr->getArrayCopy();
    return pq_data(array_column($arr, $field));
}
?>