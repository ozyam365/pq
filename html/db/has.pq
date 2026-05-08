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
        <h1 class="pq-main-title">has();</h1>

    </div>
    
    <!-- 3. 짧은 요약 (엔진 철학 반영) -->
    <p class="pq-short-desc">
         선택된 테이블이 존재하는지 검사합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">
    <!-- 1. 한줄설명 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>
    <div class="mb-4 ps-4">
        <pq>db.users.has();</pq> <span class="text-muted">→  타겟 테이블이 현재 DB에 물리적으로 존재하는지 true/false로 답변합니다</span>
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

  // 테이블 존재 여부에 따라 설계도(make) 집행 결정
  if (db.users.has()):
     print("users 테이블이 이미 존재합니다.");
  else:
     print("users 테이블이 없습니다. 설계도를 집행합니다.");
     db.users.make(); // 테이블 생성
  endif;
]]</pq></pre>
</div>
	<hr class="new-hr">
    <!-- 3. 출력결과 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>
    <div class="ps-4 mb-4">
<pre>
✔true/false
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
✔데이터 유무와 상관없이 테이블 자체가 만들어져 있는지만 봅니다.
✔where나 sort 같은 체이닝은 무시되며, 오직 db.테이블명에만 집중합니다.
✔테이블이 없을 때 발생할 수 있는 쿼리 에러를 미연에 방지
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
→ 결과가 이상할경우  db에 테이블 존재 유무 확인해볼것
</pre>
        </li>
    </ul>
</div>
