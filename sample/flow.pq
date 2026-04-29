import "config.pq";

@text = "안녕하세요PQ엔진입니다";

print("--- 헌법 2조 StrFlow 테스트 ---");

// 1. 왼쪽 정렬 절단
@left = @text.sort("left").hancut(10);
print("LEFT : " . @left); // 예상: 안녕하세..

// 2. 오른쪽 정렬 절단
@right = @text.sort("right").hancut(10);
print("RIGHT: " . @right); // 예상: ..엔진입니다

print("가공 완료.");