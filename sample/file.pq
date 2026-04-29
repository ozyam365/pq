// 예시: API로 데이터를 가져와서 파일로 저장하기
@data = http.url("https://test.com").send();
file.save("log.txt", @data);

print("저장 완료!");