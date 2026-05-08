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
        <h1 class="pq-main-title">insert();</h1>

    </div>
    
    <!-- 3. 짧은 요약 (엔진 철학 반영) -->
    <p class="pq-short-desc">
         테이블에  새로운 데이터를 삽입합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">
    <!-- 1. 한줄설명 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>
    <div class="mb-4 ps-4">
        <pq>db.table.insert(@data);</pq> <span class="text-muted">→ users 테이블에 새로운 사용자 1명을 추가합니다.</span>
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

  @r = []; 
  @r["name"] = "홍길동2";
  @r["age"] = 32;
  @res = db.users.insert(@r);

  // 확인이 필요할 때만 출력
  if (@res) print("성공");
]]</pq></pre>
</div>
	<hr class="new-hr">
    <!-- 3. 출력결과 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>
    <div class="ps-4 mb-4">
<pre>
✔ 1 row inserted

idx: 9
name: 홍길동2
age: 32
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
✔ 배열(@r)에 데이터를 담아 insert
✔ db.users.insert(@r)로 users 테이블에 추가
✔ 성공 시 1 row inserted 반환
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
→ 에러시 db연결상태 확인할것
→ 배열 변수(@r) 에 미리 값을 담아 놓을것	
</pre>
        </li>
    </ul>
</div>
