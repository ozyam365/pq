<?php
/**
 * PQ Core Functions (v0.8.9)
 * [수사 종결] pagenavi() 정밀화 및 데이터 세탁 기능 강화
 * [보안 수사] pq_clean()의 수사 범위를 넓혀 XSS 방어력 증강
 */

class PQData extends ArrayObject {
    /**
     * 🕵️ 객체 접근 수사: (@req).name 형태 대응
     */
    public function __get($n) { 
        return isset($this[$n]) ? $this[$n] : null; 
    }

    /**
     * 🕵️ [이름 확정] pagenavi: 현재 수사 조건(파라미터)을 유지하며 특정 값만 교체
     * 사용법: [[= (@req).pagenavi(['page' => 2]) ]]
     */
    public function pagenavi($add = []) {
        // 1. 현재 유입된 모든 파라미터 확보
        $current = $this->getArrayCopy();
        
        // 2. 새로운 단서(page 등)와 병합 (기존값 덮어쓰기)
        $data = array_merge($current, $add);
        
        // 3. 수사에 방해되는 빈 값(empty)은 제거하여 URL 최적화
        $data = array_filter($data, function($v) { 
            return ($v !== '' && $v !== null); 
        });

        /**
         * 4. [긴급 수정] PHP_SELF 대신 REQUEST_URI를 활용하여 
         * 라우팅 환경(pq365)에서도 정확한 현재 경로를 유지하도록 함
         */
        $url_parts = parse_url($_SERVER['REQUEST_URI']);
        $path = $url_parts['path'];
        
        $query = http_build_query($data);
        return $path . ($query ? "?" . $query : "");
    }

    // 🕵️ 짧은 이름을 선호할 때를 위한 별칭 (Alias)
    public function url($add = []) { return $this->pagenavi($add); }

    public function filled($key = null) {
        $val = ($key === null) ? (string)$this : ($this[$key] ?? null);
        return !empty(trim((string)$val));
    }

    public function only(...$keys) {
        $res = [];
        // 가변 인자 대응 (배열로 들어오든 콤마로 들어오든 처리)
        $flat_keys = is_array($keys[0] ?? null) ? $keys[0] : $keys;
        foreach ($flat_keys as $k) {
            if ($this->offsetExists($k)) $res[$k] = $this[$k];
        }
        return pq_data($res);
    }

    public function except(...$keys) {
        $res = $this->getArrayCopy();
        $flat_keys = is_array($keys[0] ?? null) ? $keys[0] : $keys;
        foreach ($flat_keys as $k) unset($res[$k]);
        return pq_data($res);
    }

    public function has($key) { return $this->offsetExists($key); }
    public function where($c) { return pq_where($this, $c); }
    public function pluck($f) { return pq_pluck($this, $f); }
    public function join($glue = ', ') { return implode($glue, $this->getArrayCopy()); }
    public function count(): int { return parent::count(); }
    
    public function __toString() { 
        $raw = $this->getArrayCopy();
        return is_string($raw) ? $raw : ""; 
    }
}

/**
 * 데이터 수사대 투입 함수
 */
function pq_data($a) { return new PQData((array)$a); }

/**
 * 🕵️ [제4원칙 준수] 유해 성분 정밀 소독
 */
function pq_clean($v) { 
    if (is_array($v) || is_object($v)) return $v;
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); 
}

/**
 * 🕵️ 배열 데이터 필터링 수사 (where 절 모사)
 */
function pq_where($arr, $cond) {
    if ($arr instanceof PQData) $arr = $arr->getArrayCopy();
    if (!is_array($arr)) return pq_data([]);

    preg_match('/(\w+)\s*([><=]+)\s*(.*)/', trim((string)$cond, "\"' "), $m);
    if(!$m) return pq_data($arr);
    
    list(, $f, $op, $val) = $m; 
    $val = trim($val, " '\"");

    $res = array_filter($arr, function($r) use ($f, $op, $val) {
        $r = (object)$r; 
        $t = $r->$f ?? 0;
        switch($op) {
            case '>':  return $t > $val;
            case '<':  return $t < $val;
            case '>=': return $t >= $val;
            case '<=': return $t <= $val;
            case '==':
            case '=':  return $t == $val;
            default:   return false;
        }
    });
    return pq_data(array_values($res));
}

/**
 * 🕵️ 특정 증거(컬럼)만 추출
 */
function pq_pluck($arr, $field) {
    if ($arr instanceof PQData) $arr = $arr->getArrayCopy();
    if (!is_array($arr)) return pq_data([]);
    return pq_data(array_column($arr, $field));
}
?>
