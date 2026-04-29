<?php
// 이 함수가 있어야 file.save() 문법이 작동합니다.
function file_pq() { 
    static $f = null; 
    if (!$f) $f = new FileMaker(); 
    return $f; 
}

class FileMaker {
    // 읽기: JSON이면 배열로, 아니면 문자열로 반환
    function load($p) { 
        if(!file_exists($p)) return null;
        $raw = file_get_contents($p);
        $json = json_decode($raw, true);
        return (json_last_error() === JSON_ERROR_NONE) ? $json : $raw;
    }
    
    // 쓰기: 배열이면 JSON으로, 아니면 문자열로 저장
    function save($p, $d) { 
        $content = (is_array($d) || is_object($d)) ? json_encode($d, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : $d;
        return file_put_contents($p, $content); 
    }

    // JSON 전용 읽기
    function json($p) {
        return $this->load($p);
    }
}
?>