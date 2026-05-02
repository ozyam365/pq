// sample/insert.pq
db.connect();

@record = []; 
@record["name"] = "홍길동2";
@record["age"] = 32;

// 결과는 그냥 @ 변수에 담으면 됩니다. (외울 필요 없음)
@res = db.users.insert(@record);

// 확인이 필요할 때만 출력
if (@res) print("성공");
