import "config.pq";
(@user) = db.users.where("idx=1").one();

print("--- 헌법 원칙 준수 테스트 ---");

// 객체는 무조건 (@)로 감싸고 마침표!
print("이름: " . (@user).name);

// identity.pq 수정
if (isset((@user).point)) {
    print("포인트: " . (@user).point.money());
} else {
    print("포인트 정보가 없습니다.");
}