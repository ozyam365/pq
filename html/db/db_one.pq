<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 one()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.table.where("조건").one(); 
					<small class="text-muted">※ → 조건에 맞는 데이터 중 단 하나만 객체로 가져옵니다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect(); 

  // idx가 1번인  레코드 정보를  빼오기
 (@u) = db.users.where("idx = 1").one(); 
]]

안녕하세요, [[=(@u).name]]님!
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
✔ 1 row selected

idx: 1
name: 홍길동
age: 22
status: active
</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">

<pre>
✔where()와 체이닝되어 정확한 타겟만 지정하여 가져옵니다.
✔내부적으로 LIMIT 1 수사 지침이 자동으로 가동되어 엔진 부하를 최소화합니다.
</pre>					
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
→ 에러시 db연결상태 확인할것
→ 여러 명이 검색되어도 무조건 첫 번째 한 명만 가져옵니다. 
→ 특정인을 지목하려면 where("idx = ...")를 정교하게 사용하세요.
→ 결과값이 하나이므로 객체로 받으시면 편하게 쓰실수 있습니다 (@u).name		
</pre>					
					</p>
				</div>
			</div>
    </div>
  </div>
</div>
