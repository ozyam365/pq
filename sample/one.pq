db.connect();
// 2. 조회
@user = db.users.where("idx = 1").one();

// 3. 출력
if (@user) {
    print("성공: " . @user.name);
} else {
    print("데이터 없음");
}