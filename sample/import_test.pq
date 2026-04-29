// 1. [헌법 1조] 공통 설정 가져오기
import "config.pq";

// 2. 이미 config에서 connect를 했으므로 바로 조회 가능
@user = db.users.where("idx = 1").one();

print("--- Import 및 데이터 조회 테스트 ---");
print("사용자: " . @user.name);