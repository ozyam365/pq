// 이 주소는 텍스트만 뱉기 때문에 HTML이 나올 수가 없습니다.
@res = http.url("https://api.ipify.org").send();

print("--- 내 IP 확인 ---");
print(@res);