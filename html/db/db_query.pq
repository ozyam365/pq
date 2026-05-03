<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 query()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.query("조건");
					<small class="text-muted">※ → 조건에 맞는 query문을 실행한다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect(); 
  // 바로 쿼리문 실행
  //@res는 대기변수로 트리거에 따라 변화합니다.
  @res = db.query("SELECT * FROM users WHERE status = 'active' LIMIT 5"); 
]]

[[ foreach(@res as (@row)): ]]
  이름: [[=(@row).name]]
[[ endforeach; ]]
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>


✔ 5 row selected
idx: 10 name: 홍길동10 | age: 32 | status: active
idx: 11 name: 홍길동11 | age: 32 | status: active
idx: 12 name: 홍길동12 | age: 32 | status: active
idx: 13 name: 홍길동13 | age: 32 | status: active
idx: 14 name: 홍길동14 | age: 32 | status: active

</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔ db에 연결할것
✔ db.query("쿼리문 입력")
✔ 복잡한 쿼리문일경우 이용하면 좋습니다.
</pre>							
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
→ 에러시 db연결상태 확인할것
→ 결과가 이상할경우  db에 데이터 값 확인해볼것
</pre>							
					</p>
				</div>
			</div>
    </div>
  </div>
</div>