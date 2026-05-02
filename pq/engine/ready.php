<?php
/**
 * PQ 번역관 (v0.7.9)
 * 제4원칙 준수: URL 보호, 도트 문법 결착 및 수사관(file) 추가
 */
function pq_ready($code) {
    if (empty(trim((string)$code))) return '';

    // 1. [외교 면권] URL 보호막 (마침표 사수)
    $urls = [];
    if (preg_match_all('/https?:\/\/[^\s<>"\']+/', $code, $matches)) {
        foreach ($matches[0] as $i => $url) { 
            $token = "[[PQURL{$i}]]";
            $urls[$token] = $url;
            $code = str_replace($url, $token, $code);
        }
    }

    // 2. [태그리스 집행] 줄 단위 번역 및 PHP 태그 자동 래핑
    $lines = explode("\n", $code);
    foreach ($lines as &$line) {
        $trimmed = trim($line);
        if ($trimmed === "" || strpos($line, '<?php') !== false) continue;

        // PQ 핵심 명령어 수색 (추가: file 수사관)
        $is_pq_cmd = preg_match('/^(@|trace|debug|print|if|for|foreach|db|include|import|file|\()/i', $trimmed);
        $is_html = (strpos($trimmed, '<') === 0);

        if ($is_pq_cmd && !$is_html) {
            $line = "<?php " . $line . " ?>";
        }
    }
    $code = implode("\n", $lines);

    // 3. [신분 세탁] 변수 및 도트 문법 변환
    // (@var). -> $var-> (메서드 체이닝 보호)
    $code = preg_replace('/\((@\w+)\)\./', '$1->', $code);
    // (@var) -> $var (단순 괄호 제거)
    $code = preg_replace('/\((@\w+)\)/', '$1', $code);
    // @var -> $var
    $code = preg_replace('/@(\w+)/', '$$1', $code);

    // 4. [수사관 특명] 특정 키워드 도트(.)를 화살표(->)로 치환
    // http. -> http()-> (전역 함수 호출형태로 변환)
    $code = preg_replace('/http\.([a-zA-Z_]\w*)/i', 'http()->$1', $code);
    
    // file. -> file_pq()-> (아까 만든 file_pq 숏컷 연결)
    $code = preg_replace('/file\.([a-zA-Z_]\w*)/i', 'file_pq()->$1', $code);

    // trace( -> Trace::add( (로그 장비)
    $code = preg_replace('/trace\(/i', 'Trace::add(', $code);

    // 기타 가드 키워드들 처리
    $guards = ['trace', 'debug', 'filter', 'on', 'replace', 'money', 'clean', 'trim', 'hancut'];
    foreach ($guards as $g) {
        $code = preg_replace('/' . $g . '\.([a-zA-Z_]\w*)/', $g . '->$1', $code);
    }

    // 5. [성역 복구 및 URL 원복]
    $code = str_replace(['trace->on', 'debug->on'], 'Trace::on', $code);
    
    if (!empty($urls)) {
        foreach ($urls as $token => $url) {
            $code = str_replace($token, $url, $code);
        }
    }

    return trim($code);
}
?>