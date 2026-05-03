<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 sort()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.table.sort("컬럼명 [ASC/DESC]");
					<small class="text-muted">  ※ → 수사 데이터의 정렬 순서를 결정합니다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect(); 
  
  // 1. 최신 등록순 (idx 큰 순서)으로 3개 추출
  @row = db.users.sort("idx DESC").limit(3); 

  // 2. 이름 가나다순으로 전체 추출
  @row = db.users.sort("name ASC");
]]
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
✔ 3 row selected
idx: 3 name: 홍길동 | age: 32 | a  : 9
idx: 2 name: 홍길동 | age: 32 | a  : 8
idx: 1 name: 홍길동 | age: 32 | a  : 7 


✔ 5 row selected
idx: 4 name: 김길동 | age: 32 | a  : 9
idx: 3 name: 나길동 | age: 32 | a  : 8
idx: 5 name: 다길동 | age: 32 | a  : 7 
idx: 1 name: 라길동 | age: 32 | a  : 8
idx: 2 name: 마길동 | age: 32 | a  : 7 
</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔ db에 연결할것
✔ where(), limit()과 결합하여 "특정 조건의 최신 데이터 N개"를 뽑아낼 때 필수적입니다.
✔ SQL의 ORDER BY 문법을 그대로 수용하여 idx DESC, idx ASC와 같이 명확하게 사용합니다.
</pre>							
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
→ 에러시 db연결상태 확인할것
→ 정렬 기준(컬럼명)이 테이블에 존재하지 않으면  오류가 발생하므로 idx 등 정확한 컬럼명을 기입해야 합니다.
</pre>							
					</p>
				</div>
			</div>
    </div>
  </div>
</div>