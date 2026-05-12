<?php
/**
 * PQ 엔진 라우터 (router.php v1.0.5)
 * [수사 지침] 모든 경로는 /pq365 서브디렉토리를 정밀 여과한 후 매칭한다.
 * [파라미터 증거 확보] URL에 포함된 변수는 즉시 $GLOBALS로 압수하여 엔진 전역에서 사용한다.
 */

class PQRouter {
    private static $map = [];

    /**
     * 라우팅 규칙 설정
     */
    public static function set($path, $file) {
        self::$map[$path] = $file;
    }

    /**
     * 경로 수사 및 타겟 파일 반환
     */
    public static function run() {
        // 1. 현재 접속 경로 파악 (서브디렉토리 /pq365 대응 및 정규화)
        $current_path = $_SERVER['PATH_INFO'] ?? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // 경로 세척: /pq365 제거 및 앞뒤 슬래시 정리 후 다시 붙임
        $current_path = '/' . trim(str_replace('/pq365', '', $current_path), '/');
        
        // 루트(/) 접속 시 기본 index 처리 (필요 시)
        if ($current_path === '/') $current_path = '/index';

        foreach (self::$map as $pattern => $target_file) {
            // :id 와 같은 파라미터를 정규식 그룹으로 변환
            $regex = preg_replace('/\:(\w+)/', '(?P<$1>[^/]+)', $pattern);
            
            // 🕵️ 정밀 수색 시작
            if (preg_match("#^$regex$#", $current_path, $matches)) {
                // 파라미터 증거 확보 (숫자 인덱스 제외, 이름 있는 그룹만 추출)
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        // 전역 변수화 (엔진의 핵심 편의성)
                        $GLOBALS[$k] = $v;
                        // 파일 경로 내의 변수 치환 (ex: /user/:id -> /user/123)
                        $target_file = str_replace(":$k", $v, $target_file);
                    }
                }
                
                // 수사 성공: 확정된 타겟 파일 경로 반환
                return $target_file;
            }
        }

        // 🚨 수사망 탈출: 매칭되는 경로가 없을 경우 false 반환
        return false; 
    }
}
?>
