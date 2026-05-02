// sample/safe.pq
http.safe()
trace("CHECK", "보안 세탁 집행 시도") // 이 로그가 Trace Report에 찍혀야 합니다.

@name = http.get("name")
print "결과: " . @name
