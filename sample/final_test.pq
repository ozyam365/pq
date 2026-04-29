db.connect();

// 1. HTTP로 내 IP 가져오기
@my_ip = http.url("https://api.ipify.org").send();

// 2. FILE에 접속 로그 기록 (JSON 형식)
@log_data = ["time" => "now()", "ip" => @my_ip];
file.save("access_log.json", @log_data);

// 3. DB에 접속 기록 저장 (users나 logs 테이블)
db.logs.insert(["ip" => @my_ip, "memo" => "PQ 엔진 테스트"]);

print("--- 최종 결과 ---");
print("가져온 IP: " . @my_ip);
print("파일 및 DB 저장 완료!");