<?php
// 1. DB 연결 (db()->connect())
db()->connect();

$now = date("Y-m-d H:i:s");

// 2. 데이터 준비
$record = []; // array() 대신 현대적인 [] 권장
$record["name"] = "홍길동2";
$record["age"] = 32;
$record["reg_date"] = $now;

// 3. 첫 번째 insert 실행
db()->users->insert($record);

// 4. 등록 확인 (변수에 담아 성공 여부 체크)
$ok = db()->users->insert($record);

// 5. 결과 출력 (pq_print가 불리언/문자열/배열을 알아서 처리)
pq_print($ok); 
pq_print("insert 완료");