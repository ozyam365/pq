<!-- like.pq -->
<div class="pq-page-header">

    <!-- 브레드크럼 -->
    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>DB function</span>
    </nav>

    <!-- 타이틀 -->
    <div class="pq-title-area">
        <h1 class="pq-main-title">like();</h1>
    </div>

    <!-- 설명 -->
    <p class="pq-short-desc">
        LIKE 검색 조건을 추가합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">

    <!-- 1 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>

    <div class="mb-4 ps-4">
        <pq>like(field, keyword)</pq>
        <span class="text-muted">→ LIKE 검색</span>
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
      .like("name", @search)
      .limit(10);
]]
</pq></pre>
</div>

<hr class="new-hr">

    <!-- 3 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>

    <div class="ps-4 mb-4">
        name 컬럼 기준으로 검색된 유저 목록
    </div>

<hr class="new-hr">

    <!-- 4 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-orange">4</span> 결과/특징
    </div>

    <ul class="list-unstyled ps-4 mb-4 small text-secondary">
        <li><i class="bi bi-check-lg me-2"></i>문자열 검색에 사용됩니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>내부적으로 SQL LIKE 문법을 사용합니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>where() 없이 단독 사용 가능합니다.</li>
    </ul>

<hr class="new-hr">

    <!-- 5 -->
    <div class="pq-section-title text-danger">
        <span class="pq-badge bg-red">5</span> 주의
    </div>

    <ul class="list-unstyled ps-4 small text-danger opacity-75">
        <li>• 검색어가 비어있으면 조건이 추가되지 않습니다.</li>
        <li>• 대량 데이터 검색 시 limit() 사용을 권장합니다.</li>
    </ul>

</div>