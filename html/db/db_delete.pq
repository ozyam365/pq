<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 delete()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.table.where("조건").delete(); 
					<small class="text-muted">※ → 특정 데이터를  삭제합니다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[
  db.connect();

  // idx가 10번인 레코드 삭제 
  @res = db.users.where("idx = 10").delete();
  print(@res . "건의 데이터 삭제");
]]
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
✔ 1 row deleted

idx: 10
name: 홍길동2
age: 25
status: active
</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">

<pre>
✔where()와 체이닝되어 정확한 타겟만 삭제하므로 안전합니다.
✔삭제 행의 개수를 반환하여 삭제 성공 여부를 즉시 확인 가능합니다.
</pre>					
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
→ 에러시 db연결상태 확인할것
→ where() 없이 delete()를 가동하면 테이블 전체가 삭젤 위험이 있으므로, 엔진 레벨에서 "조건 없는 삭제루틴 차단" 로직이 작동합니다.
</pre>					
					</p>
				</div>
			</div>
    </div>
  </div>
</div>
