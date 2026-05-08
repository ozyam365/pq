<!-- FILE chain.pq -->
<div class="pq-page-header">

    <!-- 브레드크럼 -->
    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>FILE function</span>
    </nav>

    <!-- 타이틀 -->
    <div class="pq-title-area">
        <h1 class="pq-main-title">체인패턴</h1>
    </div>

    <!-- 설명 -->
    <p class="pq-short-desc">
        file의 다양한 실전 패턴을 확인합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">

    <!-- 1 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">1</span> 기본 업로드
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @file = file.upload("doc")
      .path("/upload")
      .save();
]]
</pq></pre>
</div>

<div class="ps-4 pt-3 mb-4">
    업로드된 파일을 upload 폴더에 저장합니다.
    <br><br>

    <span class="text-secondary small">
        사용함수 : upload() / path() / save()
    </span>
</div>

<hr class="new-hr">


    <!-- 2 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">2</span> 이미지 업로드 제한
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @img = file.upload("photo")
      .image()
      .limit("5MB")
      .save();
]]
</pq></pre>
</div>

<div class="ps-4 pt-3 mb-4">
    이미지 파일만 허용하며 최대 5MB까지 업로드합니다.
    <br><br>

    <span class="text-secondary small">
        사용함수 : upload() / image() / limit() / save()
    </span>
</div>

<hr class="new-hr">


    <!-- 3 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">3</span> 랜덤 파일명 저장
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @img = file.upload("photo")
      .random()
      .save();
]]
</pq></pre>
</div>

<div class="ps-4 pt-3 mb-4">
    파일명을 랜덤 문자열로 변경하여 저장합니다.
    <br><br>

    <span class="text-secondary small">
        사용함수 : upload() / random() / save()
    </span>
</div>

<hr class="new-hr">


    <!-- 4 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">4</span> 파일 읽기
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @txt = file.read("/data/test.txt");
]]
</pq></pre>
</div>

<div class="ps-4 pt-3 mb-4">
    파일 내용을 읽어옵니다.
    <br><br>

    <span class="text-secondary small">
        사용함수 : read()
    </span>
</div>

<hr class="new-hr">


    <!-- 5 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">5</span> 파일 이동
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   file.move("/tmp/a.txt", "/backup/a.txt");
]]
</pq></pre>
</div>

<div class="ps-4 pt-3 mb-4">
    파일을 다른 위치로 이동합니다.
    <br><br>

    <span class="text-secondary small">
        사용함수 : move()
    </span>
</div>

<hr class="new-hr">


    <!-- 6 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">6</span> 파일 다운로드
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   file.download("/upload/manual.pdf");
]]
</pq></pre>
</div>

<div class="ps-4 pt-3 mb-4">
    브라우저에서 파일 다운로드를 실행합니다.
    <br><br>

    <span class="text-secondary small">
        사용함수 : download()
    </span>
</div>

<hr class="new-hr">


    <!-- 7 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">7</span> 영상 스트리밍
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   file.stream("/video/movie.mp4");
]]
</pq></pre>
</div>

<div class="ps-4 pt-3 mb-4">
    대용량 영상 파일을 스트리밍 방식으로 출력합니다.
    <br><br>

    <span class="text-secondary small">
        사용함수 : stream()
    </span>
</div>

<hr class="new-hr">


    <!-- 8 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">8</span> 폴더 내부 전체 삭제
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   file.clear("/cache");
]]
</pq></pre>
</div>

<div class="ps-4 pt-3 mb-4">
    폴더 내부 파일과 하위 폴더를 모두 정리합니다.
    <br><br>

    <span class="text-secondary small">
        사용함수 : clear()
    </span>
</div>

</div>