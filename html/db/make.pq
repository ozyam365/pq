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
        <h1 class="pq-main-title">make();</h1>

    </div>
    
    <!-- 3. 짧은 요약 (엔진 철학 반영) -->
    <p class="pq-short-desc">
       미리작성한 파밀명.sql일 계정에 업로드후 실행하여 데이터베이스에 테이블을 생성합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">
    <!-- 1. 한줄설명 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-blue">1</span> 한줄설명
    </div>
    <div class="mb-4 ps-4">
        <pq>db.users.make("파일.sql");</pq> <span class="text-muted">→ 작성한 sql파일을 읽어서 테이블을 생성합니다.</span>
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

  // 테이블이 없는 경우에만 설계도를 집행하는 정석 문법
  if (!db.users.has()):
     print("현장이 비어있습니다. 설계도를 집행합니다...");
     @result = db.users.make("mbr.sql"); 
     print(@result); // " [테이블 생성 완료]..."
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
✔ sql 파일의 테이블 생성
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
✔ 파일 기반: /set/ 폴더 내파일을  미리 만들어 놓고 사용하면 편리
✔ has()과 결합하면 "설치 여부를 체크하여 설치할 수 있습니다.
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
→ 결과가 이상할 경우 해당 sql파일 구문이 틀렸나 확인해 볼것	
</pre>
        </li>
    </ul>
</div>
