<!-- chain.pq -->
<div class="pq-page-header">

    <!-- 브레드크럼 -->
    <nav class="pq-breadcrumb">
        <span>Core Pages</span>
        <i class="bi bi-chevron-right"></i>
        <span>DB function</span>
    </nav>

    <!-- 메인 타이틀 -->
    <div class="pq-title-area">
        <h1 class="pq-main-title">CHAIN PATTERN</h1>
    </div>

    <!-- 짧은 설명 -->
    <p class="pq-short-desc">
        PQ는 함수를 연결하여 자연스럽게 읽히는 DB 패턴을 구성합니다.
    </p>
</div>

<hr class="pq-hr">

<div class="pq-content-card">

    <!-- 패턴 1 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">1</span> 조건 검색 + 단건 조회
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @user = db.users
      .where("idx=1")
      .one();
]]
</pq></pre>
</div>

    <div class="ps-4 pt-3 mb-4">
        특정 유저 1명만 가져옵니다.
        <br><br>

        <span class="text-secondary small">
            사용함수 : where() / one()
        </span>
    </div>

<hr class="new-hr">

    <!-- 패턴 2 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">2</span> 조건 연결 + 범위 검색
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @list = db.users
      .where("state='on'")
      .and("age > 20")
      .limit(10);
]]
</pq></pre>
</div>

    <div class="ps-4 pt-3 mb-4">
        활성화된 성인 유저 10명을 가져옵니다.
        <br><br>

        <span class="text-secondary small">
            사용함수 : where() / and() / limit()
        </span>
    </div>

<hr class="new-hr">

    <!-- 패턴 3 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">3</span> OR 조건 검색
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @list = db.users
      .where("state='on'")
      .or("level='admin'")
      .limit(10);
]]
</pq></pre>
</div>

    <div class="ps-4 pt-3 mb-4">
        활성 유저 또는 관리자 계정을 검색합니다.
        <br><br>

        <span class="text-secondary small">
            사용함수 : where() / or() / limit()
        </span>
    </div>

<hr class="new-hr">

    <!-- 패턴 4 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">4</span> 컬럼 배열 추출
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @emails = db.users
      .where("state='on'")
      .pluck("email");
]]
</pq></pre>
</div>

    <div class="ps-4 pt-3 mb-4">
        활성화된 유저의 email 목록만 배열로 가져옵니다.
        <br><br>

        <span class="text-secondary small">
            사용함수 : where() / pluck()
        </span>
    </div>

<hr class="new-hr">

    <!-- 패턴 5 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">5</span> 정렬 + 범위 제한
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @list = db.users
      .sort("idx")
      .limit(5);
]]
</pq></pre>
</div>

    <div class="ps-4 pt-3 mb-4">
        최신 유저 5명을 가져옵니다.
        <br><br>

        <span class="text-secondary small">
            사용함수 : sort() / limit()
        </span>
    </div>

<hr class="new-hr">

    <!-- 패턴 6 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">6</span> LIKE 검색
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

    <div class="ps-4 pt-3 mb-4">
        이름 기준으로 검색합니다.
        <br><br>

        <span class="text-secondary small">
            사용함수 : like() / limit()
        </span>
    </div>

<hr class="new-hr">

<!-- 패턴 7 -->
<div class="pq-section-title">
    <span class="pq-badge bg-info">7</span> 조건부 체인
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

<div class="ps-4 pt-3 mb-4">
    검색어가 있을 때만 조건을 추가합니다.
    <br><br>

    <span class="text-secondary small">
        사용함수 : when() / like() / limit()
    </span>
</div>

<hr class="new-hr">

    <!-- 패턴 8 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">8</span> 데이터 수정
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   db.users
      .where("idx=1")
      .update({
         name:"홍길동",
         age:20
      });
]]
</pq></pre>
</div>

    <div class="ps-4 pt-3 mb-4">
        특정 유저 정보를 수정합니다.
        <br><br>

        <span class="text-secondary small">
            사용함수 : where() / update()
        </span>
    </div>

<hr class="new-hr">

    <!-- 패턴 9 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">9</span> 데이터 삭제
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   db.users
      .where("idx=1")
      .delete();
]]
</pq></pre>
</div>

    <div class="ps-4 pt-3 mb-4">
        특정 유저를 삭제합니다.
        <br><br>

        <span class="text-secondary small">
            사용함수 : where() / delete()
        </span>
    </div>

<hr class="new-hr">

    <!-- 패턴 10 -->
    <div class="pq-section-title">
        <span class="pq-badge bg-info">10</span> JOIN 연결
    </div>

<div class="pq-code-block ms-4" style="white-space: pre-wrap; background:#f9f9f9; border-radius:8px;">
<pre><pq>
[[ 
   @list = db.users
      .join("posts", "users.idx = posts.user_idx")
      .limit(5);
]]
</pq></pre>
</div>

    <div class="ps-4 pt-3 mb-2">
        users 와 posts 테이블을 연결합니다.
        <br><br>

        <span class="text-secondary small">
            사용함수 : join() / limit()
        </span>
    </div>

</div>