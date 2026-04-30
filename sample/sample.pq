import "config.pq";

debug.on(); // 여기서부터 아래의 변환 과정을 화면에 출력합니다.

(@users) = [
    ["name" => "Gemini", "point" => 5000],
    ["name" => "ChatGPT", "point" => 7000]
];

(@vip) = @users.where("point > 6000");

debug.off(); // 디버깅 종료
print(@vip);