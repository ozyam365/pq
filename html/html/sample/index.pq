// test.pq 상단
http.safe()             // 1. 들어오는 모든 녀석들을 일단 세탁
http.required(['id'])   // 2. 'id'라는 녀석이 없으면 여기서 즉시 체포(종료)

@id = http.get("id")    // 3. 이제 안심하고 사용
print "수사 대상 ID: " . @id
