<?php
// /pq/engine/view.php

function pq_view($view_name, $data = []) {
    // .pq 확장자와 .php 확장자 모두 대응
    $view_path = $_SERVER['DOCUMENT_ROOT'] . "/html/" . $view_name;
    if (!file_exists($view_path)) {
        $view_path .= (file_exists($view_path . ".pq")) ? ".pq" : ".php";
    }
    
    if (!file_exists($view_path)) return "🔍 View Not Found: $view_path";

    $content = file_get_contents($view_path);
    
    /**
     * 1. [지능형 구문 수사] 과잉 파싱 방지 및 체인 문법 적용
     * 문서 전체를 건드리지 않고 [[ ]] 내부만 정밀 타격합니다.
     */
    $content = preg_replace_callback('/\[\[\s*(.*?)\s*\]\]/s', function($matches) {
        $inner = trim($matches[1]);

        // [판별 가이드] 시스템 예약어, @변수, (@)객체, import, 배열, 함수로 시작할 때만 가동
        $is_system = preg_match('/^(db|form|file|iot|session|http|date|time|sys|cron|app|api|qrcode|mail|chat|@|\(@|import|fn|\[)/', $inner);

        if ($is_system) {
            // A. import "파일명"; 처리 (include 기능 통합)
            if (str_starts_with($inner, 'import')) {
                return "<?php include_once \$_SERVER['DOCUMENT_ROOT'] . '/html/' . str_replace(['\"', \"'\", ';'], '', substr('$inner', 6)) . (str_contains('$inner', '.') ? '' : '.pq'); ?>";
            }

            // B. 체인 문법 (.) -> PHP 화살표 (->) 변환
            // 예약어와 변수 뒤의 마침표만 안전하게 치환하여 일반 텍스트 보존
            $inner = preg_replace('/([a-zA-Z0-9_@\(\)]+)\./', '$1->', $inner);
            
            // C. @변수를 PHP 변수 $로 변환
            $inner = str_replace('@', '$', $inner);

            return "<?php $inner ?>";
        }

        // 시스템 예약어가 아니면 (예: 이미지의 db.connect() 설명 등) 그대로 텍스트 출력
        return $inner; 
    }, $content);

	// 파서 내부의 변환 로직에 추가
	$content = preg_replace_callback('/\[\[=(.*?)\]\]/s', function($matches) {
		$inner = trim($matches[1]);
		
		// @변수를 PHP $변수로 변환
		$inner = str_replace('@', '$', $inner);
		
		// 최종적으로 echo 문으로 변환
		return "<?php echo $inner; ?>";
	}, $content);

    // {{ }} 출력 문법 처리
    $content = preg_replace('/{{\s*(.*?)\s*}}/', '<?php echo pq_clean($1); ?>', $content);

    // pq_ready를 통해 최종 코어 엔진 규격으로 정렬
    $php_code = pq_ready($content);

    // 2. 디버그 보고서 출력
    if (isset($GLOBALS['PQ_DEBUG_ON']) && $GLOBALS['PQ_DEBUG_ON']) {
        echo "<fieldset style='border:1px solid #0f0; background:#000; color:#0f0; margin:10px 0;'><legend> [VIEW 수사보고] </legend>";
        echo "<textarea style='width:100%; height:150px; background:#111; color:#0f0; border:none;'>$php_code</textarea></fieldset>";
    }

    // 3. 실전 집행
    ob_start();
    if (!empty($data)) extract($data); 
    
    try {
        eval("?>" . $php_code);
    } catch (Throwable $e) {
        echo "❌ [제3원칙 위반] 문법 커플이 맞지 않습니다: " . $e->getMessage();
    }
    
    $output = ob_get_clean();

    /**
     * 🕵️‍♂️ [공백 결착 수사대] 레이아웃 밀착 최적화
     */
    $output = preg_replace('/>\s+([^<])/u', '>$1', $output);
    $output = preg_replace('/([^>])\s+</u', '$1<', $output);

    return $output;
}
?>