<!-- dir.pq -->
<div class="pq-page-header">

    <!-- 브레드크럼 -->
    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>FILE function</span>
    </nav>

    <!-- 타이틀 -->
    <div class="pq-title-area">
        <h1 class="pq-main-title">dir();</h1>
    </div>

    <!-- 설명 -->
    <p class="pq-short-desc">
        파일의 폴더 경로를 반환합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">

    <!-- 1 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>

    <div class="mb-4 ps-4">
        <pq>dir(file)</pq>
        <span class="text-muted">→ 폴더 경로 추출</span>
    </div>

<hr class="new-hr">

    <!-- 2 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-green">2</span> 실제코드
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @dir = file.dir("/upload/photo.jpg");
]]
</pq></pre>
</div>

<hr class="new-hr">

    <!-- 3 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>

    <div class="ps-4 mb-4">
        파일이 포함된 폴더 경로를 반환합니다.
    </div>

<hr class="new-hr">

    <!-- 4 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-orange">4</span> 결과/특징
    </div>

    <ul class="list-unstyled ps-4 mb-4 small text-secondary">
        <li><i class="bi bi-check-lg me-2"></i>파일명을 제외한 폴더 경로만 반환합니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>파일 위치 분석에 자주 사용됩니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>경로 문자열 형태로 반환됩니다.</li>
    </ul>

<hr class="new-hr">

    <!-- 5 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-purple">5</span> 출력 예시
    </div>

<div class="pq-code-block ms-4 mb-4" style="background:#f9f9f9; border-radius:8px;">
<pre>
/upload
/backup/image
/data/config
</pre>
</div>

<hr class="new-hr">

    <!-- 6 -->
    <div class="pq-section-title text-danger">
        <span class="pq-badge bg-red">6</span> 주의
    </div>

    <ul class="list-unstyled ps-4 small text-danger opacity-75">
        <li>• 마지막 파일명은 제외됩니다.</li>
        <li>• 폴더 경로만 반환됩니다.</li>
    </ul>

</div>