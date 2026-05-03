<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 cnt()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.table.where("조건").cnt(); 
					<small class="text-muted">※ → 조건에 걸린 레코드의 개수를 숫자로 반환합니다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect(); 

  // 1. 전체 레코드 수 파악
  @total = db.users.cnt(); 

  // 2. 특정 조건(20세 이상)에 맞는 인원의 레코드
  @adult_cnt = db.users.where("age > 20").cnt(); 
]]

현재  인원은 총 [[=@total]]명이며, 그중 성인은 [[=@adult_cnt]]명입니다.
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
 1
</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">

<pre>
✔DB의 COUNT(*) 기능을 사용하여 대규모 데이터도 순식간에 파악합니다.
✔where 이 설정되어 있다면 그 안에서만 개수를 세고, 없다면 테이블 전체를 집계합니다.

</pre>					
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
→ 에러시 db연결상태 확인할것
→ cnt()는 숫자만 반환하므로, 실제 데이터(이름, 나이 등)가 필요하다면 foreach나 one()을 병행해서 사용해야 합니다.
</pre>					
					</p>
				</div>
			</div>
    </div>
  </div>
</div>
