import "config.pq";


import "config.pq";

(@tel) = "010-1234-5678";
(@clean_tel) = filter("0-9").on(@tel).replace();
print("필터: " . @clean_tel);

(@users) = [
    ["name" => "A", "point" => 500],
    ["name" => "B", "point" => 1500],
    ["name" => "C", "point" => 2000]
];

// 여기서 터질 확률이 높습니다: 체이닝 처리 확인
(@vip) = @users.where("point > 1000").pluck("name");
print("VIP 목록:");
print(@vip);



