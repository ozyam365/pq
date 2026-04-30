// PQ 헌법 제1조 및 제3조 준수
(@user) = db.users.where("idx = @idx").one();

// PQ 헌법 제2조 (StrFlow) 및 Identity 출력
print((@user).name . " 님의 마이페이지");
print("보유 포인트: " . (@user).point.money());