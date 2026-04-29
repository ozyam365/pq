// sample/list.pq
db.connect();

// 방금 넣은 녀석들 역순으로 10개만 리스트로 가져오기
@data = db.users.sort("idx desc").limit(1, 10);

print(@data);
