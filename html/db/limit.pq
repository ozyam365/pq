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
        <h1 class="pq-main-title">limit();</h1>

    </div>
    
    <!-- 3. 짧은 요약 (엔진 철학 반영) -->
    <p class="pq-short-desc">
        테이블의 테이터를 개수만큼 가져온다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">
    <!-- 1. 한줄설명 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>
    <div class="mb-4 ps-4">
        <pq>db.table.limit(개수, [시작위치]);</pq> <span class="text-muted">→  해당 개수 만큼 데이터를 가져온다.</span>
    </div>
	<hr class="new-hr">
    <!-- 2. 실제코드 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-green">2</span> 실제코드
    </div>
<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
  db.connect(); 

  // 케이스 A: 3개 레코드만 추출할때
  @row = db.users.limit(3); 

  // 케이스 B: 데이터 5개 를 10번째 위치부터  추출할때
  @row = db.users.limit(5,10); 
]]</pq></pre>
</div>
	<hr class="new-hr">
    <!-- 3. 출력결과 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>
    <div class="ps-4 mb-4">
<pre>
✔ 5 row
id: 1 name: 홍길동1 age: 31
id: 2 name: 홍길동2 age: 32
id: 3 name: 홍길동3 age: 33

✔ 5 row
id: 10 name: 홍길동10 age: 32
id: 11 name: 홍길동11 age: 32
id: 12 name: 홍길동12 age: 32
id: 13 name: 홍길동13 age: 32
id: 14 name: 홍길동14 age: 32
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
✔ db에 연결할것
✔ db.users.limit(3);  3개 레코드만 추출할때
✔ db.users.limit(5,10);  5개 데이터  10번째 데이터 부터 추출할때
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
📍 limit(개수, 시작위치) (헷갈림 금지)
→ 에러시 db연결상태 확인할것
→ 결과가 이상할경우  db에 데이터 값 확인해볼것
→ 에러시 테이블 연결했나 확인 db.[테이블].limit(3);	
</pre>
        </li>
    </ul>
</div>
