<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 pluck()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.table.where("조건").pluck("컬럼명");
					<small class="text-muted">※ → 특정 증거(컬럼)만 골라내어 1차원 배열로 만든다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect();

  // 활성 상태인 사용자의 이메일만 싹 긁어오기 (대기 변수에서 즉시 추출)
  @emails = db.users.where("status = 'active'").pluck("email");

  // 결과는 ["user1@test.com", "user2@test.com", ...] 형태의 순수 배열입니다.
  print(@emails); 
]]
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
✔ ["user1@test.com", "user2@test.com","user3@test.com",...] 

</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔foreach를 돌며 별도의 배열에 값을 담는 번거로운 과정을 한 줄로 끝냅니다.
✔추출된 배열은 즉시 @emails.join(", ") 처럼 PQ 변수 가공 문법으로 이어질 수 있습니다.
✔전체 레코드를 객체화하지 않고 필요한 값만 뽑아내므로 대규모 데이터 처리 시 유리합니다.
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