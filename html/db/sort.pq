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
        <h1 class="pq-main-title">sort();</h1>

    </div>
    
    <!-- 3. 짧은 요약 (엔진 철학 반영) -->
    <p class="pq-short-desc">
        테이블의 데이터를 컬럼명을 기준으로 옵션에 따라 정렬합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">
    <!-- 1. 한줄설명 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>
    <div class="mb-4 ps-4">
        <pq>db.table.sort("컬럼명 [ASC/DESC]");</pq> <span class="text-muted">→ 데이터의 필트명을 기준으로 정렬 순서를 결정합니다.</span>
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
  
  // 1. 최신 등록순 (idx 큰 순서)으로 3개 추출
  @row = db.users.sort("idx DESC").limit(3); 

  // 2. 이름 가나다순으로 전체 추출
  @row = db.users.sort("name ASC");
]]</pq></pre>
</div>
	<hr class="new-hr">
    <!-- 3. 출력결과 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>
    <div class="ps-4 mb-4">
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
✔ where(), limit()과 결합하여 "특정 조건의 최신 데이터 N개"를 뽑아낼 때 필수적입니다.
✔ SQL의 ORDER BY 문법을 그대로 수용하여 idx DESC, idx ASC와 같이 명확하게 사용합니다.
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
→ 정렬 기준(컬럼명)이 테이블에 존재하지 않으면  오류가 발생하므로 idx 등 정확한 컬럼명을 기입해야 합니다.
</pre>
        </li>
    </ul>
</div>
