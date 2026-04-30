import "config.pq";

print("--- DB CUD 실전 테스트 ---");

// 1. Insert 테스트
@new_user = ["name" => "테스터", "point" => 1000];
db.users.insert(@new_user);

// 2. Update 테스트 (안전장치 확인)
print("위험한 업데이트 시도...");
db.users.update(["point" => 0]); // WHERE가 없으므로 TRACE에 에러 찍히고 실행 안 됨

print("안전한 업데이트 실행...");
db.users.where("name = '테스터'").update(["point" => 2000]);

// 3. Delete 테스트
db.users.where("name = '테스터'").delete();

print("모든 CUD 테스트 완료.");