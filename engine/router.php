<?php
class PQRouter {
    private static $map = [];

    public static function set($path, $file) {
        self::$map[$path] = $file;
    }

    public static function execute($current_path) {
        foreach (self::$map as $pattern => $file) {
            // :name 패턴을 정규식으로 치환
            $regex = preg_replace('/\:(\w+)/', '(?P<$1>[^/]+)', $pattern);
            if (preg_match("#^$regex$#", $current_path, $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) $GLOBALS[$k] = $v; // @변수화
                }
                return $file;
            }
        }
        return $current_path;
    }
}
?>