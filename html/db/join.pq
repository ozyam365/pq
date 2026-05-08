<!-- connect.pq 상단 디자인 -->
<div class="pq-page-header">
    <!-- 1. 브레드크럼 (경로 표시) -->
    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>DB function</span>
    </nav>

    <!-- 2. 메인 타이틀 & 상태 표시 -->
    <div class="pq-title-area">
        <h1 class="pq-main-title">join();</h1>

    </div>
    
    <!-- 3. 짧은 요약 (엔진 철학 반영) -->
    <p class="pq-short-desc">
        기존 테이블에 해당 조인조건에 맞는 테이블을 조인합니다. 기본은 INNER JOIN 입니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">
    <!-- 1. 한줄설명 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>
    <div class="mb-4 ps-4">
        <pq>db.table.join("join할테이블", "조건","생략가능 옵션->LEFT/RIGHT");</pq> <span class="text-muted">→ 해당 조인 조건에 맞는 테이블을 조인한다. (기본은 INNER JOIN)</span>
    </div>
	<hr class="new-hr">
    <!-- 2. 실제코드 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-green">2</span> 실제코드
    </div>
<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>[[
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
]]</pq></pre>
</div>
	<hr class="new-hr">
    <!-- 3. 출력결과 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>
    <div class="ps-4 mb-4">
<pre>
✔ 2 rows combined & selected
작성자: 홍길동10 / 글제목: PQ 엔진 v0.7 개발 일지
작성자: 김철수 / 글제목: Lazy DB 철학에 대하여.
</pre>
    </div>
	<hr class="new-hr">
    <!-- 4. 결과/특징 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-orange">4</span> 결과/특징
    </div>
    <ul class="list-unstyled ps-4 mb-4 small text-secondary">
		<li>
<pre>
✔ 체이닝 유지: join 후에도 where, sort, limit을 마음대로 이어 붙일 수 있습니다.
✔ 유연한 타입: 기본은 INNER JOIN이며, 세 번째 인자로 "LEFT", "RIGHT" 등을 지정할 수 있습니다.
✔ Lazy Chaining: foreach가 시작되기 전까지는 연결 설계도만 작성할 뿐, DB에는 무리를 주지 않습니다.
</pre>
		</li>
    </ul>
	<hr class="new-hr">
    <!-- 5. 주의 -->
    <div class="pq-section-title text-danger">
        <span class="pq-badge bg-red">5</span> 주의 <i class="bi bi-exclamation-triangle-fill ms-1"></i>
    </div>
    <ul class="list-unstyled ps-4 small text-danger opacity-75">
        <li>
<pre>		
→ 컬럼 중복: 두 테이블에 같은 이름의 컬럼(예: idx)이 있다면, field("users.idx, posts.title") 처럼 명시해 주는 것이 좋습니다.
→ 연결 조건: 온점(.)과 이퀄(=)을 사용한 연결 조건을 정확히 기재하세요.
</pre>
        </li>
    </ul>
</div>
