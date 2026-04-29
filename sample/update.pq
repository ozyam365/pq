db.connect();

// 1. 업데이트할 데이터를 먼저 정의해야 합니다!
@record = ["name" => "수정된이름", "age" => 99];

// 2. 실행
db.users.where("idx=1").update(@record);

// 성공여부 확인
@ok = db.users.where("idx=1").update(@record);
print(@ok);