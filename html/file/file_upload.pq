<div class="container-fulid">
  <div class="row">
    <div class="col pt-4 pb-4">
			<!-- 헌법 조항 카드 리스트 -->
			<div class="list-group list-group-flush shadow-sm rounded-3 border">
				<div class="list-group-item p-4 bg-light">
					<h3 class="fw-bold text-danger"> 📍 upload()</h3>
				</div>				
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-primary"><span class="badge bg-primary me-2">1</span>한줄설명</h5>
					<p class="mb-2 mt-2">file.upload(@form[file]).path("/up").save();
					<small class="text-muted">※ → 파일을 업로드합니다</small>
				</div>

				<div class="list-group-item p-4">
					<h5 class="fw-bold text-success"><span class="badge bg-success me-2">2</span>실제코드</h5>
					<p class="mb-0 mt-2">
<pre>
<pq>
[[ 
  @new_name = file.upload(@form[upfile])
                  .path("/data/uploads")
                  .allow("jpg, png, gif")
                  .save();

  if (@new_name):
     print("업로드 성공: " . @new_name);
  else:
     print("업로드 실패 (확장자 불일치 혹은 용량 초과)");
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
✔ /path("여기서 시정한 경로")/ 해당파일

</pre>
					 </p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-warning"><span class="badge bg-warning text-dark me-2">4</span>결과/특징</h5>
					<p class="mb-0 mt-2">
<pre>
✔중복 체크(Rename), 보안(Allow), 용량 제한(Limit)을 모두 포함
✔중복 피한 최종 파일명을 반환
</pre>							
					</p>
				</div>
				<div class="list-group-item p-4">
					<h5 class="fw-bold text-danger"><span class="badge bg-danger text-dark me-2">5</span>주의 ⚠</h5>
					<p class="mb-0 mt-2">
<pre>
→ 에러시 해당 디렉토리가 존재하는지 확인 할것
→ 결과가 이상할경우  업로드 파일의 이상 여부 체크할것
</pre>							
					</p>
				</div>
			</div>
    </div>
  </div>
</div>