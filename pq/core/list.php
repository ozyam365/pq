<?php
/**
 * PQ List & Pagination Manager (v1.1.0)
 * [수사 종결] 기존 검색/필터 조건을 유지하며 정밀 페이징 집행
 * [보강] db() 객체와의 체이닝 연동 강화
 */

class ListMaker {
    private $db_obj; // 수사 중인 DB 객체
    private $page = 1;
    private $size = 10;

    /**
     * @param object $db_obj DBMaker 객체 (ex: db().users)
     */
    function __construct($db_obj) {
        // 문자열로 들어오면 객체로 변환, 객체면 그대로 수용
        $this->db_obj = is_string($db_obj) ? db()->$db_obj : $db_obj;
    }

    /**
     * 🕵️ 페이지 설정
     */
    function page($p = 1, $s = 10) {
        $this->page = max(1, (int)$p);
        $this->size = max(1, (int)$s);
        return $this;
    }

    /**
     * 🕵️ 수사 집행: 데이터와 전체 통계를 통합 보고
     */
    function execute() {
        // 1. 전체 개수 수사 (기존 where/join 조건이 유지된 상태에서 수행)
        $total = $this->db_obj->cnt();

        // 2. 범위 축소 수사 (Limit 적용)
        $offset = ($this->page - 1) * $this->size;
        
        // 정렬이 설정되어 있지 않다면 기본 idx 정렬 적용
        if (empty($this->db_obj->order)) {
            $this->db_obj->sort("idx", "DESC");
        }

        // 데이터 압수 (IteratorAggregate를 통해 배열화)
        $rows = [];
        $res = $this->db_obj->limit($this->size, $offset);
        foreach ($res as $row) {
            $rows[] = $row;
        }

        // 수사 기록
        if (class_exists('Trace')) {
            Trace::add("LIST", "Table: {$this->db_obj->table}, Page: $this->page, Total: $total");
        }

        return (object)[
            "total" => (int)$total,
            "page"  => $this->page,
            "size"  => $this->size,
            "rows"  => $rows,
            "last"  => ceil($total / $this->size) // 마지막 페이지 번호 추가
        ];
    }
}

/**
 * LIST 헬퍼 함수
 * 사용법: [[ @list = pq_list(db.users.where("level", 1)).page(@req.page, 20).execute(); ]]
 */
function pq_list($db_obj) {
    return new ListMaker($db_obj);
}
?>
