🚀 핵심 구조
# ⚡ PQ - PHP DSL Query Engine

Write DB queries like this:

```pq
db.connect();

@res = list("users").page(1,10);

print(@res);

No SQL. No ORM. Just simple DSL.

🔥 Why PQ?
✔ No SQL strings everywhere
✔ Simple DSL syntax
✔ Array-based insert/update
✔ Built-in pagination
✔ Safe WHERE filtering
✔ Debug / Production mode
📦 Installation
git clone https://github.com/ozyam365/pq.git
⚙️ Config
/set/cfg_app.php
define('DEBUG', true);
/set/cfg_db.php
<?php
$_SQL_HOST = "localhost";
$_SQL_USER = "user";
$_SQL_PASS = "password";
$_SQL_NAME = "dbname";
🧪 Quick Start
1️⃣ Connect DB
db.connect();
2️⃣ List (Pagination)
@res = list("users").page(1,10);
print(@res);
3️⃣ Insert
@record = array();
@record["name"] = "홍길동";
@record["age"] = 30;

db.users.insert(@record);
4️⃣ Update
@record = array();
@record["name"] = "수정";

db.users.where("idx=1").update(@record);
5️⃣ Delete
db.users.where("idx=1").delete();
🧠 DSL Rules
DSL	PHP
@var	$var
print()	pq_print()
list()	pq_list()
db.users	db()->users
⚡ How it works
.pq → ready.php → PHP 변환 → tmp 파일 → 실행
🛡️ Safety
WHERE validation
Dangerous keyword blocking
Escaped values
🧪 Debug Mode
define('DEBUG', true);

Shows compiled PHP code

📌 Philosophy

Keep it simple.

No heavy ORM
No complex abstraction
Just fast and readable queries
🚀 Roadmap
API auto generator
Admin panel
CRUD auto mapping
📄 License

MIT
