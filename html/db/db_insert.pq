<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 insert()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.table.insert(@data)
					<small class="text-muted">※ → users 테이블에 새로운 사용자 1명을 추가합니다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect(); 
  //@res는 아직형태가 안잡힌 대기변수라고 이해하시면 됩니다. triger전의 변수
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
✔ 1 row inserted

idx: 9
name: 홍길동2
age: 32
</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔ 배열(@r)에 데이터를 담아 insert
✔ db.users.insert(@r)로 users 테이블에 추가
✔ 성공 시 1 row inserted 반환
</pre>					
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
→ 에러시 db연결상태 확인할것
→ 배열 변수(@r) 에 미리 값을 담아 놓을것
</pre>					
					</p>
				</div>
			</div>
    </div>
  </div>
</div>
