<!-- and.pq -->
<div class="pq-page-header">

    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>DB function</span>
    </nav>

    <div class="pq-title-area">
        <h1 class="pq-main-title">and();</h1>
    </div>

    <p class="pq-short-desc">
        기존 조건에 AND 조건을 추가합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">

    <!-- 1 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>

    <div class="mb-4 ps-4">
        <pq>and(condition)</pq>
        <span class="text-muted">→ AND 조건 추가</span>
    </div>

<hr class="new-hr">

    <!-- 2 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-green">2</span> 실제코드
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @list = db.users
      .where("state='on'")
      .and("age > 20");
]]
</pq></pre>
</div>

<hr class="new-hr">

    <!-- 3 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>

    <div class="ps-4 mb-4">
        state가 on 이고 age가 20 초과인 유저 목록
    </div>

<hr class="new-hr">

    <!-- 4 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-orange">4</span> 결과/특징
    </div>

    <ul class="list-unstyled ps-4 mb-4 small text-secondary">
        <li><i class="bi bi-check-lg me-2"></i>where() 이후 추가 조건을 연결합니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>복수 조건을 자연스럽게 연결할 수 있습니다.</li>
    </ul>

<hr class="new-hr">

    <!-- 5 -->
    <div class="pq-section-title text-danger">
        <span class="pq-badge bg-red">5</span> 주의
    </div>

    <ul class="list-unstyled ps-4 small text-danger opacity-75">
        <li>• 단독 호출 시 where() 처럼 동작합니다.</li>
        <li>• SQL AND 조건으로 연결됩니다.</li>
    </ul>

</div>
