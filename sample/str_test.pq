db.connect();
@user = db.users.where("idx = 1").one();

print("--- StrFlow 가공 테스트 ---");
print("이름: " . @user.name);
// 이제 pq_money($user->point) 로 변환되어 안전합니다.
print("포인트: " . @user.point.money()); 