<?php
require_once __DIR__ . '/db_builder.php';

class DB {

    private static $pdo = null;

    /**
     * 🔥 DB 연결 (자동 / 재사용)
     */
    public static function con() {

        if (self::$pdo !== null) {
            return self::$pdo;
        }

        require ROOT . '/set/db.php';

        try {
            self::$pdo = new PDO(
                "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
                $DB_USER,
                $DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );

            return self::$pdo;

        } catch (PDOException $e) {
            die("DB Connection Failed: " . $e->getMessage());
        }
    }

    /**
     * 🔥 SELECT (결과 반환)
     */
	public static function query($sql) {
		$pdo = self::con();
		$start = microtime(true);
		$stmt = $pdo->query($sql);
		$result = $stmt->fetchAll();
		$time = microtime(true) - $start;
		Trace::sql($sql, $time);   // 🔥 추가
		return $result;
	}

    /**
     * 🔥 INSERT / UPDATE / DELETE
     */
	public static function exec($sql) {
		$pdo = self::con();
		$start = microtime(true);
		$res = $pdo->exec($sql);
		$time = microtime(true) - $start;
		Trace::sql($sql, $time);   // 🔥 추가
		return $res;
	}

    /**
     * 🔥 pq용 alias (짧게)
     */
    public static function ext($sql) {
        return self::exec($sql);
    }

    /**
     * 🔥 PDO 직접 접근 (확장용)
     */
    public static function pdo() {
        return self::con();
    }

    /**
     * 🔥 체이닝 시작점
     */
    public static function from($table) {
        return new DBBuilder($table);
    }
}
?>