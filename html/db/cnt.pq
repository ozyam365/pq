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
        <h1 class="pq-main-title">cnt();</h1>

    </div>
    
    <!-- 3. 짧은 요약 (엔진 철학 반영) -->
    <p class="pq-short-desc">
        테이터베이스에서 조건에 맞는 값의 수를 셉니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">
    <!-- 1. 한줄설명 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>
    <div class="mb-4 ps-4">
        <pq>db.table.where("조건").cnt();</pq><span class="text-muted">→ 조건에 걸린 레코드의 개수를 숫자로 반환합니다.</span>
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

  // 1. 전체 레코드 수 파악
  @total = db.users.cnt(); 

  // 2. 특정 조건(20세 이상)에 맞는 인원의 레코드
  @adult_cnt = db.users.where("age > 20").cnt(); 
]]

현재  인원은 총 [[=@total]]명이며, 그중 성인은 [[=@adult_cnt]]명입니다.</pq></pre>
</div>
	<hr class="new-hr">
    <!-- 3. 출력결과 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>
    <div class="ps-4 mb-4">
<pre>
✔  1
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
✔DB의 COUNT(*) 기능을 사용하여 대규모 데이터도 순식간에 파악합니다.
✔where 이 설정되어 있다면 그 안에서만 개수를 세고, 없다면 테이블 전체를 집계합니다.
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
→ cnt()는 숫자만 반환하므로, 실제 데이터(이름, 나이 등)가 필요하다면 foreach나 one()을 병행해서 사용해야 합니다.	
</pre>
        </li>
    </ul>
</div>
