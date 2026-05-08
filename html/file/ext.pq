<!-- ext.pq -->
<div class="pq-page-header">

    <!-- 브레드크럼 -->
    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>FILE function</span>
    </nav>

    <!-- 타이틀 -->
    <div class="pq-title-area">
        <h1 class="pq-main-title">ext();</h1>
    </div>

    <!-- 설명 -->
    <p class="pq-short-desc">
        파일 확장자를 확인합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">

    <!-- 1 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>

    <div class="mb-4 ps-4">
        <pq>ext(file)</pq>
        <span class="text-muted">→ 확장자 추출</span>
    </div>

<hr class="new-hr">

    <!-- 2 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-green">2</span> 실제코드
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @ext = file.ext("/upload/photo.jpg");
]]
</pq></pre>
</div>

<hr class="new-hr">

    <!-- 3 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>

    <div class="ps-4 mb-4">
        파일 확장자를 문자열로 반환합니다.
    </div>

<hr class="new-hr">

    <!-- 4 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-orange">4</span> 결과/특징
    </div>

    <ul class="list-unstyled ps-4 mb-4 small text-secondary">
        <li><i class="bi bi-check-lg me-2"></i>파일의 마지막 확장자를 추출합니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>업로드 검사 및 MIME 처리에 자주 사용됩니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>확장자만 문자열 형태로 반환합니다.</li>
    </ul>

<hr class="new-hr">

    <!-- 5 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-purple">5</span> 출력 예시
    </div>

<div class="pq-code-block ms-4 mb-4" style="background:#f9f9f9; border-radius:8px;">
<pre>
jpg
png
pdf
txt
</pre>
</div>

<hr class="new-hr">

    <!-- 6 -->
    <div class="pq-section-title text-danger">
        <span class="pq-badge bg-red">6</span> 주의
    </div>

    <ul class="list-unstyled ps-4 small text-danger opacity-75">
        <li>• 확장자가 없는 파일은 빈 문자열이 반환될 수 있습니다.</li>
        <li>• 보안 검사는 mimeType() 과 함께 사용하는 것을 권장합니다.</li>
    </ul>

</div>