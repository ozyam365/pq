<?php
class PQRouter {
    private static $map = [];

    public static function set($path, $file) {
        self::$map[$path] = $file;
    }

	public static function run() {
		// 1. 현재 접속 경로 파악 (서브디렉토리 /pq365 대응)
		$current_path = $_SERVER['PATH_INFO'] ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$current_path = '/' . trim(str_replace('/pq365', '', $current_path), '/');
		
		foreach (self::$map as $pattern => $target_file) {
			$regex = preg_replace('/\:(\w+)/', '(?P<$1>[^/]+)', $pattern);
			
			if (preg_match("#^$regex$#", $current_path, $matches)) {
				// 파라미터 주입 로직 (기존과 동일)
				foreach ($matches as $k => $v) {
					if (is_string($k)) {
						$GLOBALS[$k] = $v;
						$target_file = str_replace(":$k", $v, $target_file);
					}
				}
				
				// 핵심: 여기서 직접 실행하지 않고 타겟 파일 경로를 반환합니다.
				return $target_file;
			}
		}
		return false; // 매칭 실패
	}
}
?>