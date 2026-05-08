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
        <h1 class="pq-main-title">one();</h1>

    </div>
    
    <!-- 3. 짧은 요약 (엔진 철학 반영) -->
    <p class="pq-short-desc">
        데이터베이스에서 하나의 자료만 개체로 가져온다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">
    <!-- 1. 한줄설명 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>
    <div class="mb-4 ps-4">
        <pq>db.table.where("조건").one(); </pq> <span class="text-muted">→조건에 맞는 데이터 중 단 하나만 객체로 가져옵니다.</span>
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

  // idx가 1번인  레코드 정보를  빼오기
 @u = db.users.where("idx = 1").one(); 
]]

안녕하세요, [[=(@u).name]]님!</pq></pre>
</div>
	<hr class="new-hr">
    <!-- 3. 출력결과 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>
    <div class="ps-4 mb-4">
<pre>
✔ 1 row selected

idx: 1
name: 홍길동
age: 22
status: active
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
✔where()와 체이닝되어 정확한 타겟만 지정하여 가져옵니다.
✔내부적으로 LIMIT 1 수사 지침이 자동으로 가동되어 엔진 부하를 최소화합니다.	
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
→ 여러 명이 검색되어도 무조건 첫 번째 한 명만 가져옵니다. 
→ 특정인을 지목하려면 where("idx = ...")를 정교하게 사용하세요.
→ 결과값이 하나이므로 객체로 받으시면 편하게 쓰실수 있습니다 (@u).name		
→ @u = db.users.where("idx = 1").one();   @u는 대기변수 상태이므로 가져온 데이터를 객체로 승급시켜 사용합니다.(@u).name
</pre>
        </li>
    </ul>
</div>
