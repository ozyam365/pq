import "config.pq";

// 1. 데이터 수사
(@me) = db.users.where("name = '이상민'").one();

// [원칙 5] 여기서 먼저 변수 내용물을 까봅니다 (포인트 0원 범인 검거용)
print("--- DB에서 갓 뽑아온 데이터 원본 ---");
print((@me)); 

(@log_data) = db.logs.sort("idx desc").limit(1, 10);
(@list) = (@log_data).rows;

// 2. 뷰 호출
print( pq_view("mypage", ["me" => @me, "logs" => @list]) );
