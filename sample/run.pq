import "config.pq";

// DB에서 데이터 가져오기
(@users) = db.users.sort("idx desc").rows();

// 뷰 엔진으로 데이터 던지기
print( pq_view("user_list", ["members" => @users]) );
