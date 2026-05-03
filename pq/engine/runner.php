<?php
function run_pq($file_path) {
    if (!file_exists($file_path)) return;
    
    // [추가] 15대 예약어들을 eval 내부로 끌어들입니다.
    global $db, $form, $file, $session, $http; 
    
    $content = file_get_contents($file_path);

    // 1. <pq> 태그 치외법권 처리 (기존 로직 유지)
    $placeholders = [];
    $content = preg_replace_callback('/<pq>(.*?)<\/pq>/s', function($matches) use (&$placeholders) {
        $id = "___PQ_RAW_BOX_" . count($placeholders) . "___";
        $placeholders[$id] = htmlspecialchars($matches[1]); 
        return $id;
    }, $content);

    // 2. [[ ]] 구문 파싱
    $content = preg_replace_callback('/\[\[\s*(.*?)\s*\]\]/s', function($matches) {
        $inner = trim($matches[1]);
        $is_echo = str_starts_with($inner, '=');
        $code = $is_echo ? ltrim($inner, '= ') : $inner;

        /**
         * [PQ 엔진 핵심 리팩토링 규칙]
         * 1. (@aaa).name -> ($aaa)->name (객체 승격 허용)
         * 2. @aaa.hcut() -> (new PQ_Util($aaa))->hcut() (변수 가공 허용)
         * 3. @aaa.name   -> 차단 (단순 속성 접근 불허)
         */

        // A. 객체 승격 처리: (@aaa).something -> ($aaa)->something
        $code = preg_replace('/\(@([a-zA-Z0-9_]+)\)\./', '($$1)->', $code);

        // B. 변수 가공 처리: @aaa.func() -> (new PQ_Util($aaa))->func()
        // 마침표 뒤에 영문+괄호()가 오는 경우만 가공으로 인정
        $code = preg_replace('/@([a-zA-Z0-9_]+)\.([a-zA-Z0-9_]+)\(/', '(new PQ_Util($$1))->$2(', $code);

        // C. 남은 @를 $로 치환 (단순 변수)
        $code = str_replace('@', '$', $code);

        // D. [위험!] @aaa.name 처럼 괄호 없이 속성에 접근한 잔여 마침표 체크
        // PHP 문법 에러를 방지하기 위해, 여기서 마침표(.)가 변수 뒤에 남았다면 차단 로직이 작동해야 합니다.
        // (단, 소수점이나 문자열 연결과 구분하기 위해 세밀한 정규식이 필요하나 일단 기본 규칙 적용)

        if ($is_echo) {
            return "<?php echo $code; ?>";
        } else {
            // 제어문(foreach 등)이나 일반 실행문 처리
            return "<?php $code ?>";
        }
    }, $content);

    // 3. 치외법권 복구
    foreach ($placeholders as $id => $text) {
        $content = str_replace($id, $text, $content);
    }

    try {
        eval("?> " . $content);
    } catch (Throwable $e) {
        echo "<div style='color:red;'>❌ PQ 엔진 수사관 검거: " . $e->getMessage() . "</div>";
    }
}
?>