# ⚡ PQ Engine

간단하고 빠르게 사용할 수 있는 PHP 기반 DSL(Database Query Engine)

👉 SQL을 직접 쓰지 않고  
👉 짧은 DSL 코드로 DB 작업을 수행합니다

---

# 🚀 특징

- ✔ PHP 기반 DSL
- ✔ 배열 중심 데이터 처리
- ✔ 체이닝 방식 쿼리
- ✔ 안전한 WHERE 검사
- ✔ 디버그/운영 모드 지원
- ✔ insert / update / delete / list 지원

---

# 📁 구조
/core
db.php # DB 엔진
list.php # 페이징 리스트
util.php # 출력 및 헬퍼

/engine
ready.php # DSL → PHP 변환
runner.php # 실행 엔진

/set
cfg_app.php # DEBUG 설정
cfg_env.php # 환경 설정
cfg_db.php # DB 설정

/sample
*.pq # 샘플 코드

/tmp
pq_debug.php # 컴파일 결과


---

# ⚙️ 설정

## /set/cfg_app.php

```php
define('DEBUG', true);
/set/cfg_env.php
define('ENV', 'dev');
/set/cfg_db.php

<?php
$_SQL_HOST = "localhost";
$_SQL_USER = "user";
$_SQL_PASS = "password";
$_SQL_NAME = "dbname";


🧠 기본 개념
DSL	PHP 변환
@var	$var
print()	pq_print()
list()	pq_list()
db.users	db()->users

🧪 사용 예제
🔹 DB 연결
db.connect();
🔹 SELECT (list)
@res = list("users").page(1,10);
print(@res);
🔹 INSERT
@record = array();
@record["name"] = "홍길동";
@record["age"] = 30;

db.users.insert(@record);
🔹 UPDATE
@record = array();
@record["name"] = "수정";

db.users.where("idx=1").update(@record);
🔹 DELETE
db.users.where("idx=1").delete();
🔹 WHERE
db.users
  .where("age > 20")
  .and("name='홍길동'");
🔥 실행
run_pq("/sample/test.pq");
🧩 내부 구조
PQ → ready.php → PHP 변환 → tmp 파일 생성 → include 실행

👉 execute()는 내부에서 자동 실행됨

🛡️ 보안
WHERE 필터링
위험 키워드 차단 (drop, delete 등)
SQL injection 최소화 처리

🧪 디버그 모드
define('DEBUG', true);

👉 변환된 PHP 코드 출력

📌 주의사항
execute() 직접 사용 ❌
get/select 없음 ❌
DSL 기반 사용 ✔
배열 기반 insert/update ✔
💡 설계 철학

👉 "복잡한 ORM 대신 단순한 DSL"

빠르게 작성
직관적인 구조
유지보수 쉬움
🚀 향후 계획
API 자동 생성
관리자 페이지
CRUD 자동화

📄 License

MIT
