<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 join()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.table.join("join할테이블", "조건");
					<small class="text-muted">※ →해당 조인 조건에 맞는 테이블을 조인한다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
  db.connect();

  // [합동 수사] 유저(users)와 게시물(posts) 테이블을 하나로 묶기
  @res = db.users
           .join("posts", "users.id = posts.user_id")
           .where("users.level = 'VIP'")
           .sort("posts.idx DESC")
           .limit(5);

  foreach(@res as @row):
    // 객체 승격(@)을 통해 두 테이블의 컬럼에 모두 접근 가능
    작성자: [[=(@row).name]] / 글제목: [[=(@row).title]]
  endforeach;
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
✔ 2 rows combined & selected
작성자: 홍길동10 / 글제목: PQ 엔진 v0.7 개발 일지
작성자: 김철수 / 글제목: Lazy DB 철학에 대하여.

</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔ 체이닝 유지: join 후에도 where, sort, limit을 마음대로 이어 붙일 수 있습니다.
✔ 유연한 타입: 기본은 INNER JOIN이며, 세 번째 인자로 "LEFT", "RIGHT" 등을 지정할 수 있습니다.
✔ Lazy Chaining: foreach가 시작되기 전까지는 연결 설계도만 작성할 뿐, DB에는 무리를 주지 않습니다.
</pre>							
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
→ 컬럼 중복: 두 테이블에 같은 이름의 컬럼(예: idx)이 있다면, field("users.idx, posts.title") 처럼 명시해 주는 것이 좋습니다.
→ 연결 조건: 온점(.)과 이퀄(=)을 사용한 연결 조건을 정확히 기재하세요.
</pq>
</pre>							
					</p>
				</div>
			</div>
    </div>
  </div>
</div>