<!-- when.pq -->
<div class="pq-page-header">

    <!-- 브레드크럼 -->
    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>DB function</span>
    </nav>

    <!-- 타이틀 -->
    <div class="pq-title-area">
        <h1 class="pq-main-title">when();</h1>
    </div>

    <!-- 설명 -->
    <p class="pq-short-desc">
        특정 값이 있을 때만 조건을 추가합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">

    <!-- 1 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>

    <div class="mb-4 ps-4">
        <pq>when(value, action)</pq>
        <span class="text-muted">→ 값이 있을 때만 실행</span>
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
      .when(
         @search,
         fn(@q)=>(@q).like("name", @search)
      )
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
        검색어가 있을 때만 name 검색이 추가된 유저 목록
    </div>

<hr class="new-hr">

    <!-- 4 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-orange">4</span> 결과/특징
    </div>

    <ul class="list-unstyled ps-4 mb-4 small text-secondary">
        <li><i class="bi bi-check-lg me-2"></i>@search 값이 있을 때만 내부 코드가 실행됩니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>검색 페이지 제작에 자주 사용됩니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>if 문 없이 조건을 자연스럽게 연결할 수 있습니다.</li>
    </ul>

<hr class="new-hr">

    <!-- 5 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-purple">5</span> 내부동작
    </div>

<div class="pq-code-block ms-4 mb-4" style="background:#f9f9f9; border-radius:8px;">
<pre>
@search 값이 있으면
→ like("name", @search) 실행

@search 값이 없으면
→ 실행하지 않음
</pre>
</div>

<hr class="new-hr">

    <!-- 6 -->
    <div class="pq-section-title text-danger">
        <span class="pq-badge bg-red">6</span> 주의
    </div>

    <ul class="list-unstyled ps-4 small text-danger opacity-75">
        <li>• fn(@q)=> 는 내부 실행 코드를 의미합니다.</li>
        <li>• fn(@q)=>에서 @q 는 대기변수 상태라 (@q)로 표현되지 않습니다.</li>				
        <li>• (@q) 는 현재 db 객체입니다. 객체 사용 시작이라고 보시면 좋겠습니다.</li>
        <li>• 조건이 false면 내부 코드는 실행되지 않습니다.</li>
    </ul>

</div>