<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 yn()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.users.yn();
					<small class="text-muted">※ → 타겟 테이블이 현재 DB에 물리적으로 존재하는지 true/false로 답변합니다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect();

  // 테이블 존재 여부에 따라 설계도(make) 집행 결정
  if (db.users.yn()):
     print("users 테이블이 이미 존재합니다.");
  else:
     print("users 테이블이 없습니다. 설계도를 집행합니다.");
     db.users.make(); // 테이블 생성
  endif;
]]
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
✔true/false

</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔데이터 유무와 상관없이 테이블 자체가 만들어져 있는지만 봅니다.
✔where나 sort 같은 체이닝은 무시되며, 오직 db.테이블명에만 집중합니다.
✔테이블이 없을 때 발생할 수 있는 쿼리 에러를 미연에 방지
</pre>							
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
→ 에러시 db연결상태 확인할것
→ 결과가 이상할경우  db에 테이블 존재 유무 확인해볼것
</pre>							
					</p>
				</div>
			</div>
    </div>
  </div>
</div>