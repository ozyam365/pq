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
        <h1 class="pq-main-title">pluck();</h1>

    </div>
    
    <!-- 3. 짧은 요약 (엔진 철학 반영) -->
    <p class="pq-short-desc">
         조건에 맞튼 컬럼만 골라내어 1차원 배열로 만듭니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">
    <!-- 1. 한줄설명 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>
    <div class="mb-4 ps-4">
        <pq>db.table.where("조건").pluck("컬럼명");</pq> <span class="text-muted">→  조건에 맞는 컬럼만 골라내어 1차원 배열로 만든다.</span>
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

  // 활성 상태인 사용자의 이메일만 싹 긁어오기 (대기 변수에서 즉시 추출)
  @emails = db.users.where("status = 'active'").pluck("email");

  // 결과는 ["user1@test.com", "user2@test.com", ...] 형태의 순수 배열입니다.
  print(@emails);
]]</pq></pre>
</div>
	<hr class="new-hr">
    <!-- 3. 출력결과 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>
    <div class="ps-4 mb-4">
<pre>
✔ ["user1@test.com", "user2@test.com","user3@test.com",...] 
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
✔foreach를 돌며 별도의 배열에 값을 담는 번거로운 과정을 한 줄로 끝냅니다.
✔추출된 배열은 즉시 @emails.join(", ") 처럼 PQ 변수 가공 문법으로 이어질 수 있습니다.
✔전체 레코드를 객체화하지 않고 필요한 값만 뽑아내므로 대규모 데이터 처리 시 유리합니다.
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
→ 결과가 이상할경우  db에 데이터 값 확인해볼것	
</pre>
        </li>
    </ul>
</div>
