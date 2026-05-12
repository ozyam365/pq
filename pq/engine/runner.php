<?php
/**
 * PQ Engine Runner (v1.4.1) - [CSS/JS 성역 완전 복구판]
 * [사건 종결] CSS 레이아웃 붕괴 및 마침표 오인 사격 영구 소탕
 * [수사 전략] 성역은 보호하되, 레이아웃에 즉각 반영되도록 복구 순서를 정밀 조정한다.
 */

function run_pq($file_path) {
    if (!file_exists($file_path)) return;
    
    global $db, $form, $file, $session, $http, $date, $time, $trace, $app, $ai, $iot, $text; 
    
    $session = function_exists('session_pq') ? session_pq() : null; 
    $db      = function_exists('db') ? db() : null; 
    $http    = function_exists('http_pq') ? http_pq() : null; 
    $file    = function_exists('file_pq') ? file_pq() : null;
    $date    = function_exists('date_pq') ? date_pq() : null; 
    $time    = function_exists('time_pq') ? time_pq() : null; 
    $form    = function_exists('form_pq') ? form_pq() : null;
    $text    = function_exists('text_pq') ? text_pq() : null;

    $content = file_get_contents($file_path);

    // [Step 1] 성역(Sanctuary) 격리 - CSS, JS, PQ 예제 코드를 엔진으로부터 보호
    $placeholders = [];
    $content = preg_replace_callback('/<(style|script|pq)>(.*?)<\/\1>/is', function($m) use (&$placeholders) {
        $id = "___PQ_SECURE_ZONE_" . count($placeholders) . "___";
        $placeholders[$id] = ['tag' => $m[1], 'content' => $m[2], 'full' => $m[0]];
        return $id; 
    }, $content);

    // [Step 2] [[ ]] 구문 정밀 번역
    $content = preg_replace_callback('/\[\[\s*(.*?)\s*\]\]/s', function($m) {
        $inner = trim($m[1]);
        if (empty($inner)) return "";
        
        $lower = strtolower($inner);
        // 제어문 처리
        if ($lower === 'end') return "<?php endforeach; ?>";
        if ($lower === 'endif') return "<?php endif; ?>";
        if (str_starts_with($lower, 'foreach')) {
            $code = function_exists('pq_ready') ? pq_ready($inner) : $inner;
            return "<?php " . rtrim($code, ';') . ": ?>";
        }

        $is_echo = str_starts_with($inner, '=');
        $cmd = $is_echo ? ltrim($inner, '= ') : $inner;
        $final = function_exists('pq_ready') ? pq_ready($cmd) : $cmd;
        $final = rtrim(trim($final), ';');

        if ($is_echo) return "<?php echo @$final ?? ''; ?>";
        return "<?php $final; ?>";
    }, $content);

    /**
     * 🕵️ [Step 3] 성역 복구 (CSS/JS 레이아웃 정상화)
     */
    foreach ($placeholders as $id => $data) { 
        if ($data['tag'] === 'pq') {
            // 예제 코드는 소독하여 렌더링
            $safe_body = htmlspecialchars($data['content']);
            $content = str_replace($id, "<code class='pq-code-block'>{$safe_body}</code>", $content);
        } else {
            // style, script는 원본 그대로 복구하여 CSS가 즉시 적용되도록 함
            $content = str_replace($id, $data['full'], $content);
        }
    }

    // [Step 4] 유령 태그 청소
    $content = str_replace('<?php ?>', '', $content);

    try {
        $agents = [
            'session'=>$session, 'db'=>$db, 'http'=>$http, 'file'=>$file, 
            'date'=>$date, 'time'=>$time, 'form'=>$form, 'trace'=>$trace, 
            'iot'=>$iot, 'ai'=>$ai, 'app'=>$app, 'text'=>$text,
            'root' => $_SERVER['DOCUMENT_ROOT']
        ];
        extract($GLOBALS, EXTR_SKIP);
        extract($agents);
        
        // 최종 집행
        eval("?> " . $content);
        
    } catch (Throwable $e) {
        if (class_exists('Trace')) Trace::add("ERROR", $e->getMessage());
        echo "<div style='color:red; background:#fff; padding:10px; border:2px solid red;'>🚨 RUNNER ERROR: " . $e->getMessage() . "</div>";
    }
}
?>
