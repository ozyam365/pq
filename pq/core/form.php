<?php
/**
 * PQ Form Manager (v0.9.0)
 * [수사 지침] http 장비와 공조하여 유저 입력값을 감식하고, 검증 흐름(check)을 준비한다.
 * [파일명] /pq/core/form.php
 */

class FormMaker {
    private $data = [];
    private $errors = [];

    /**
     * 🕵️ [의미적 검거] all()
     * "사용자가 입력한 폼 데이터"라는 관점으로 데이터를 수집한다.
     */
    public function all() {
        // http 코어 수사관으로부터 원천 데이터를 넘겨받음 (공조 수사)
        if (function_exists('http')) {
            $this->data = http()->all();
        } else {
            $this->data = array_merge($_GET, $_POST);
        }
        
        // pq_data가 있다면 객체형으로 변환하여 반환
        return function_exists('pq_data') ? pq_data($this->data) : $this->data;
    }

    /**
     * 🕵️ [검증 장비] check()
     * 데이터가 수사 원칙에 맞는지 검사한다. (향후 확장 예정)
     * 예: form.check({ name: "required" })
     */
    public function check($rules = []) {
        // TODO: 필수값, 이메일 형식, 최소길이 등 정밀 검증 로직 탑재 예정
        return $this;
    }

    /**
     * 🕵️ [결과 보고] fail()
     * 수사 과정에서 검증 실패(오류)가 있었는지 확인한다.
     */
    public function fail() {
        return !empty($this->errors);
    }

    /**
     * 🕵️ [증거 목록] error()
     * 발생한 에러 메시지들을 반환한다.
     */
    public function error() {
        return $this->errors;
    }
}

/**
 * 🕵️ 예약어 form 가동 함수
 */
function form_pq() {
    static $f = null;
    if (!$f) $f = new FormMaker();
    return $f;
}

// 글로벌 스코프에서 form() 함수가 중복 정의되지 않았을 때만 선언
if (!function_exists('form')) {
    function form() { return form_pq(); }
}
