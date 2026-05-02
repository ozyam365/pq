<?php
/**
 * 리스트 및 페이징 처리 전용
 */
class ListMaker {
    private $db;
    private $table;
    private $page = 1;
    private $size = 10;

    function __construct($table) {
        $this->db = db()->$table; // 여기서 테이블 객체를 고정 (에러 차단)
        $this->table = $table;
    }

    // 체이닝을 위한 페이지 설정
    function page($p = 1, $s = 10) {
        $this->page = max(1, (int)$p);
        $this->size = max(1, (int)$s);
        return $this;
    }

    // 실행: 데이터와 토탈 개수를 한 번에
    function execute() {
        $offset = ($this->page - 1) * $this->size;

        // 1. 전체 개수 구하기 (에러 차단: count 쿼리 직접 생성)
        $count_res = db()->query("SELECT COUNT(*) as cnt FROM {$this->table}");
        $total = ($count_res) ? mysqli_fetch_assoc($count_res)['cnt'] : 0;

        // 2. 데이터 가져오기 (문자열 유지 및 빠른 함수)
        // LIMIT 부분은 "OFFSET, SIZE" 형태로 직접 처리
        $rows = $this->db
            ->sort("idx DESC")
            ->limit("$offset, $this->size") 
            ->execute();

        trace("LIST", "Page: $this->page, Total: $total");

        return [
            "total" => (int)$total,
            "page"  => $this->page,
            "size"  => $this->size,
            "rows"  => $rows ?: []
        ];
    }
}

// 숏컷 함수
function pq_list($table) {
    return new ListMaker($table);
}
?>