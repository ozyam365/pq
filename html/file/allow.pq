<!-- allow.pq -->
<div class="pq-page-header">

    <!-- 브레드크럼 -->
    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>FILE function</span>
    </nav>

    <!-- 타이틀 -->
    <div class="pq-title-area">
        <h1 class="pq-main-title">allow();</h1>
    </div>

    <!-- 설명 -->
    <p class="pq-short-desc">
        업로드 가능한 확장자를 제한합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">

    <!-- 1 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>

    <div class="mb-4 ps-4">
        <pq>allow(ext)</pq>
        <span class="text-muted">→ 허용 확장자 지정</span>
    </div>

<hr class="new-hr">

    <!-- 2 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-green">2</span> 실제코드
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @img = file.upload("photo")
      .allow("jpg,png,gif")
      .save();
]]
</pq></pre>
</div>

<hr class="new-hr">

    <!-- 3 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-dark">3</span> 출력결과
    </div>

    <div class="ps-4 mb-4">
        jpg, png, gif 파일만 업로드를 허용합니다.
    </div>

<hr class="new-hr">

    <!-- 4 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-orange">4</span> 결과/특징
    </div>

    <ul class="list-unstyled ps-4 mb-4 small text-secondary">
        <li><i class="bi bi-check-lg me-2"></i>허용할 파일 확장자를 제한합니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>쉼표(,) 기준으로 여러 확장자를 입력할 수 있습니다.</li>
        <li><i class="bi bi-check-lg me-2"></i>대소문자는 자동으로 정리됩니다.</li>
    </ul>

<hr class="new-hr">

    <!-- 5 -->
    <div class="pq-section-title text-danger">
        <span class="pq-badge bg-red">5</span> 주의
    </div>

    <ul class="list-unstyled ps-4 small text-danger opacity-75">
        <li>• 허용되지 않은 확장자는 저장되지 않습니다.</li>
        <li>• 보안을 위해 image(), mime() 와 함께 사용하는 것을 권장합니다.</li>
    </ul>

</div>
