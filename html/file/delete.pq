<!-- delete.pq -->
<div class="pq-page-header">

    <!-- 브레드크럼 -->
    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>FILE function</span>
    </nav>

    <!-- 타이틀 -->
    <div class="pq-title-area">
        <h1 class="pq-main-title">delete();</h1>
    </div>

    <!-- 설명 -->
    <p class="pq-short-desc">
        파일 또는 폴더를 삭제합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">

    <!-- 1 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>

    <div class="mb-4 ps-4">
        <pq>delete(path)</pq>
        <span class="text-muted">→ 파일 삭제</span>
    </div>

<hr class="new-hr">

    <!-- 2 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-green">2</span> 실제코드
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   file.delete("/upload/test.jpg");
]]
</pq></pre>
</div>

<hr class="new-hr">

    <!-- 3 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>

    <div class="ps-4 mb-4">
        지정된 파일 또는 폴더를 삭제합니다.
    </div>

<hr class="new-hr">

    <!-- 4 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-orange">4</span> 결과/특징
    </div>

    <ul class="list-unstyled ps-4 mb-4 small text-secondary">
        <li><i class="bi bi-check-lg me-2"></i>파일 삭제에 사용됩니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>빈 폴더 삭제도 가능합니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>삭제 성공 여부를 반환합니다.</li>
    </ul>

<hr class="new-hr">

    <!-- 5 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-purple">5</span> 사용 예시
    </div>

<div class="pq-code-block ms-4 mb-4" style="background:#f9f9f9; border-radius:8px;">
<pre>
/upload/test.jpg
/cache/temp.txt
/backup/
</pre>
</div>

<hr class="new-hr">

    <!-- 6 -->
    <div class="pq-section-title text-danger">
        <span class="pq-badge bg-red">6</span> 주의
    </div>

    <ul class="list-unstyled ps-4 small text-danger opacity-75">
        <li>• 삭제된 파일은 복구되지 않습니다.</li>
        <li>• 폴더는 내부가 비어있어야 삭제 가능합니다.</li>
    </ul>

</div>