(@user) = db.users.where("idx = 1").one();
(@list) = db.logs.limit(1, 10).rows;

// 뷰에서 $user와 $list로 쓰고 싶다면 키 이름을 똑같이 줍니다.
print( pq_view("mypage", [
    "user" => @user, 
    "list" => @list
]) );