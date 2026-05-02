<?php
class PQRouter {
    private static $map = [];

    public static function set($path, $file) {
        self::$map[$path] = $file;
    }

    public static function run() {
        // 현재 접속 경로 파악 (예: /index/wiki/intro/hello)
        $current_path = $_SERVER['PATH_INFO'] ?? '/';
        
        foreach (self::$map as $pattern => $target_file) {
            // :category, :idx 등을 정규식으로 변환
            $regex = preg_replace('/\:(\w+)/', '(?P<$1>[^/]+)', $pattern);
            
            if (preg_match("#^$regex$#", $current_path, $matches)) {
                // 1. URL 파라미터를 @변수로 자동 주입
                foreach ($matches as $k => $v) {
                    if (is_string($k)) $GLOBALS[$k] = $v;
                }
                
                // 2. 실행할 파일 경로 결정 (치환 작업)
                // html/:category/:idx.pq -> html/intro/hello.pq
                foreach ($matches as $k => $v) {
                    if (is_string($k)) $target_file = str_replace(":$k", $v, $target_file);
					//echo "Target File: " . $target_file; // 실제 어떤 파일을 찾으려 하는지 출력
                }

                // 3. 엔진 가동 (runner.php의 run_pq 호출)
                if (function_exists('run_pq')) {
                    return run_pq($target_file);
                }
                echo "🔍 Engine Error: run_pq() not found.";
                return;
            }
        }
        echo "🔍 404: Path Not Found ($current_path)";
    }
}
?>