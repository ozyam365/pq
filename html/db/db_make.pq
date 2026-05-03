<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 make()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">db.users.make("파일.sql");
					<small class="text-muted">※ → .sql파일을 읽어서 테이블을 생성합니다.</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  db.connect();

  // 테이블이 없는 경우에만 설계도를 집행하는 정석 문법
  if (!db.users.yn()):
     print("현장이 비어있습니다. 설계도를 집행합니다...");
     @result = db.users.make("mbr.sql"); 
     print(@result); // "✅ [현장 구축 완료]..."
  endif;
]]
</pq>
</pre>
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-dark"><span class="badge bg-dark me-2">3</span>출력결과</h5>
					<p class="mb-0 mt-2">
<pre>
✔ sql 파일의 테이블 생성

</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔ 파일 기반: /set/ 폴더 내파일을  미리 만들어 놓고 사용하면 편리
✔ 유연한 명명: 계정의 디렉토리에 파일을 업로드후 make("mbr.sql")처럼 다른 파일명을 지정해  만들수 있습니다.
✔ yn()과 결합하면 "설치 여부를 체크하여 설치할 수 있습니다.
</pre>							
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
→ 에러시 db연결상태 확인할것
→ 결과가 이상할 경우 해당 sql파일 구문이 틀렸나 확인해 볼것
</pre>							
					</p>
				</div>
			</div>
    </div>
  </div>
</div>