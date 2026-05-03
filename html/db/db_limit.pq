<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 limit(개수, 시작위치) (헷갈림 금지)</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.table.limit(개수, [시작위치]);
					<small class="text-muted">※ → 해당 개수 만큼 데이터를 가져온다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect(); 

  // 케이스 A: 3개 레코드만 추출할때
  @row = db.users.limit(3); 

  // 케이스 B: 데이터 5개 를 10번째 위치부터  추출할때
  @row = db.users.limit(5,10); 
]]
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
✔ 5 row
id: 1 name: 홍길동1 age: 31
id: 2 name: 홍길동2 age: 32
id: 3 name: 홍길동3 age: 33

✔ 5 row
id: 10 name: 홍길동10 age: 32
id: 11 name: 홍길동11 age: 32
id: 12 name: 홍길동12 age: 32
id: 13 name: 홍길동13 age: 32
id: 14 name: 홍길동14 age: 32
</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔ db에 연결할것
✔ db.users.limit(3);  3개 레코드만 추출할때
✔ db.users.limit(5,10);  5개 데이터  10번째 데이터 부터 추출할때
</pre>							
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
📍 limit(개수, 시작위치) (헷갈림 금지)
→ 에러시 db연결상태 확인할것
→ 결과가 이상할경우  db에 데이터 값 확인해볼것
→ 에러시 테이블 연결했나 확인 db.[테이블].limit(3);
</pre>							
					</p>
				</div>
			</div>
    </div>
  </div>
</div>