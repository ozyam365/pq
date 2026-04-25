<?php

function collect($data) {
    return new Collection($data);
}

class Collection {

    private $data;

    public function __construct($data) {
        $this->data = is_array($data) ? $data : [];
    }

	public function where($key, $op = null, $value = null) {

		// 🔥 콜백 방식 (확장 DSL)
		if (is_callable($key)) {

			$this->data = array_values(array_filter($this->data, $key));
			return $this;
		}

		// 🔥 기존 방식 유지
		$this->data = array_values(array_filter($this->data, function($item) use ($key, $op, $value) {

			if (!isset($item[$key])) return false;

			switch ($op) {
				case '>': return $item[$key] > $value;
				case '<': return $item[$key] < $value;
				case '==': return $item[$key] == $value;
				case '!=': return $item[$key] != $value;
				case '>=': return $item[$key] >= $value;
				case '<=': return $item[$key] <= $value;
			}

			return false;
		}));

		return $this;
	}

    // =========================================================
    // 🔥 MAP
    // =========================================================
    public function map($callback) {

        $this->data = array_map(function($item) use ($callback) {
            return $callback($item);
        }, $this->data);

        return $this;
    }

    // =========================================================
    // 🔥 GROUP BY
    // =========================================================
    public function groupBy($key) {

        $result = [];

        foreach ($this->data as $item) {

            if (!isset($item[$key])) continue;

            $group = $item[$key];

            if (!isset($result[$group])) {
                $result[$group] = [];
            }

            $result[$group][] = $item;
        }

        $this->data = $result;

        return $this;
    }

    // =========================================================
    // 🔥 SORT BY
    // =========================================================
    public function sortBy($key, $direction = 'asc') {

        usort($this->data, function($a, $b) use ($key, $direction) {

            $aVal = $a[$key] ?? null;
            $bVal = $b[$key] ?? null;

            if ($aVal == $bVal) return 0;

            if ($direction === 'asc') {
                return ($aVal < $bVal) ? -1 : 1;
            } else {
                return ($aVal > $bVal) ? -1 : 1;
            }
        });

        return $this;
    }

    // =========================================================
    // 🔥 LIMIT
    // =========================================================
    public function limit($count) {

        $this->data = array_slice($this->data, 0, $count);

        return $this;
    }

    // =========================================================
    // 🔥 FIRST
    // =========================================================
    public function first() {
        return $this->data[0] ?? null;
    }

    // =========================================================
    // 🔥 LAST
    // =========================================================
    public function last() {
        return end($this->data);
    }

    // =========================================================
    // 🔥 COUNT
    // =========================================================
    public function count() {
        return count($this->data);
    }

    // =========================================================
    // 🔥 GET (최종 반환)
    // =========================================================
    public function get() {
        return $this->data;
    }

    // =========================================================
    // 🔥 DEBUG (선택)
    // =========================================================
    public function dump() {
        print_r($this->data);
        return $this;
    }
	// 🔥 PLUCK (특정 키만 추출)
	public function pluck($key) {

		$this->data = array_map(function($item) use ($key) {
			return $item[$key] ?? null;
		}, $this->data);

		return $this;
	}

	// 🔥 SELECT (여러 필드)
	public function select($keys) {

		$this->data = array_map(function($item) use ($keys) {

			$result = [];

			foreach ($keys as $k) {
				$result[$k] = $item[$k] ?? null;
			}

			return $result;

		}, $this->data);

		return $this;
	}
}
?>