<?php
/**
 * PQ Engine Runner (v0.9.1)
 * [완전체] JS 스타일 문법 지원 (Dot Chaining + Object Brace)
 * [수사 보고] v0.8.210 기반으로 지피티 수사관의 소수점(1.5) 보호 지침을 완벽 반영함.
 */

function run_pq($file_path) {
    if (!file_exists($file_path)) return;
    
    // 1. 수사관 전원 배치 (Global Agents)
    global $db, $form, $file, $session, $http, $date, $time, $trace, $app, $ai, $iot; 
    
    // 엔진 가동 - 각 코어는 이미 로드되어 있어야 함 (ready.php 등에서)
    $session = session_pq(); 
    $db = db(); 
    $http = http_pq(); 
    $file = file_pq();
    $date = date_pq(); 
    $time = time_pq(); 
    $form = form_pq();

    $content = file_get_contents($file_path);

    // [Step 1] <pq> 태그 격리 (제3원칙: 커플 격리 수사)
    $placeholders = [];
    $content = preg_replace_callback('/<pq>(.*?)<\/pq>/s', function($matches) use (&$placeholders) {
        $id = "___PQ_RAW_BOX_" . count($placeholders) . "___";
        // 내부 텍스트($matches[1])만 안전하게 추출하여 보관
        $placeholders[$id] = htmlspecialchars($matches[1]); 
        return $id; 
    }, $content);

    // [Step 2] [[ ]] 구문 정밀 수사 및 변환
    $content = preg_replace_callback('/\[\[\s*(.*?)\s*\]\]/s', function($matches) {
        $inner = trim($matches[1]);
        $is_echo = str_starts_with($inner, '=');
        $code = $is_echo ? ltrim($inner, '= ') : $inner;

        // 🕵️ [수사 장비 A] JS 스타일 객체 {key:val} -> PHP 배열 ["key"=>val] 변환
        // 정규식을 통해 인자 내부의 { }를 배열 [ ]로 번역합니다.
        $code = preg_replace_callback('/\{([^\}]+)\}/s', function($m) {
            $pair_str = $m[1];
            $pairs = explode(',', $pair_str);
            $new_pairs = [];
            foreach($pairs as $p) {
                if(strpos($p, ':') !== false) {
                    list($k, $v) = explode(':', $p, 2);
                    $new_pairs[] = '"'.trim($k).'" => '.trim($v);
                } else {
                    $new_pairs[] = trim($p);
                }
            }
            return '[' . implode(', ', $new_pairs) . ']';
        }, $code);

        // 🕵️ [수사 장비 B] 정밀 점(.) 체이닝 변환 (v0.9.1 지피티 지침 반영)
        // (?<!\d) : 숫자 뒤의 점은 무시하여 1.5 같은 소수점 사건 방지
        // \. : 마침표 타겟팅
        // ([a-zA-Z_][a-zA-Z0-9_]*) : 유효한 메서드/속성명 포착

        $code = preg_replace_callback('/(["\'])(?:(?=(\\\\?))\2.)*?\1|(?<!\d)\.([a-zA-Z_][a-zA-Z0-9_]*)/', function($m) {
            // $m[3]이 존재한다는 것은 따옴표가 아닌 '점(.)+문자' 패턴이 검거되었다는 뜻입니다.
            if (!empty($m[3])) {
                return "->" . $m[3];
            }
            // 그 외(따옴표로 감싸진 문자열)는 수사망에서 제외하고 그대로 돌려줍니다.
            return $m[0];
        }, $code);
		
		
        // 🕵️ [수사 장비 C] 시스템 예약어 자동 브릿지 (db.users -> $db->users)
        $reserved = ['db', 'session', 'http', 'file', 'form', 'date', 'time', 'ai', 'iot', 'app', 'trace'];
        foreach ($reserved as $r) {
            $bridge = ($r === 'trace') ? 'Trace::' : '$' . $r . '->';
            // 예약어가 단어 경계로 시작하고 변수가 아닐 때만 치환
            $code = preg_replace('/(?<![\$a-zA-Z0-9_])' . $r . '->/i', $bridge, $code);
        }

        // 🕵️ [수사 장비 D] @ -> $ 단순 치환 (커스텀 변수 처리)
        $code = str_replace('@', '$', $code);

        // 🕵️ [수사 장비 E] 객체 승격 및 특수 가공 (v0.8.210 로직 유지)
        $code = preg_replace('/\(\$([a-zA-Z0-9_]+)\)->/', '($$1)->', $code);
        
        // 🕵️ [수사 장비 F] 제어문 및 루프 마감
        if ($code === 'end') return "<?php endforeach; ?>";
        if (preg_match('/foreach\s*\((.*?)\)/i', $code, $fe_m)) {
            return "<?php foreach(" . trim($fe_m[1]) . "): ?>";
        }

        // 구문 최종 마감 (세미콜론 보정)
        $final = rtrim($code, ';') . ";";
        return $is_echo ? "<?php echo $final ?>" : "<?php $final ?>";
    }, $content);

    // [Step 3] 격리했던 텍스트 복구 (태그 없이 알맹이만 복구)
    foreach ($placeholders as $id => $text) {
        $content = str_replace($id, $text, $content);
    }

    // [Step 4] 최종 집행 (eval)
    try {
        $agents = [
            'session'=>$session, 'db'=>$db, 'http'=>$http, 'file'=>$file, 
            'date'=>$date, 'time'=>$time, 'form'=>$form, 'trace'=>$trace,
            'app'=>$app, 'ai'=>$ai, 'iot'=>$iot
        ];
        extract($agents);
        // PHP 태그 외부로 나갔다가 다시 eval로 진입하는 방식
        eval("?> " . $content);
    } catch (Throwable $e) {
        // 제5원칙: echo로 모든 범행(에러)을 밝힌다
        echo "<div style='color:red; background:#fff; padding:15px; border:2px solid red; font-family:consolas; font-size:13px; line-height:1.6;'>";
        echo "🚨 <b>PQ 엔진 수사 보고 (v0.9.1)</b><br>";
        echo "<b>현장 파일:</b> $file_path <br>";
        echo "<b>에러 사유:</b> " . $e->getMessage() . "<br>";
        echo "<b>검거된 코드(컴파일 결과):</b> <pre style='background:#f9f9f9; padding:10px; border:1px solid #ddd;'>" . htmlspecialchars($content) . "</pre>";
        echo "</div>";
    }
}
?>
