<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 filter()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2"> db.users.filter(fn(@v) => @v.age >= 20);
					<small class="text-muted">※ → DB에서 가져온 데이터셋을 메모리 상에서 필터(Filter)로 한 번 더 거른다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect();

  // [Case A] 단독 사용: 전체 데이터를 가져와 20세 이상만 필터링
  @adults = db.users.filter(fn(@v) => @v.age >= 20);

  foreach(@adults as @u):
    이름: [[=(@u).name]]
  endforeach;

  // [Case B] 체인 사용: 1차 DB 수사(where) 후, 2차 메모리 수사(filter) 연결
  @res = db.users.where("age > 20").filter(fn(@v) => @v.level == 'VIP');

  foreach(@res as @row):
    이름: [[=(@row).name]]
  endforeach;
]]
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
✔3 rows selected (Case A)
idx: 10 name: 홍길동10 | age: 32 | a : 9 | level : VIP
idx: 11 name: 홍길동11 | age: 32 | a : 8 | level : SILVER
idx: 12 name: 홍길동12 | age: 32 | a : 7 | level : GOLD

✔1 row selected (Case B)
idx: 10 name: 홍길동10 | age: 32 | a : 9 | level : VIP
</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔db에 연결할것
✔db.users.filter 단독 사용가능   db.users.where("age > 20").filter(fn(@v) => @v.level == 'VIP'); 처럼 체인으로도 가능
✔fn(@v)는 익명함수 입니다.
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