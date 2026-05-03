[[ 
  print("<h3>📁 파일 수사관 긴급 현장 검증</h3>");
  $form = form_pq(); 
  $file = file_pq();

  // 1. 폼 데이터가 있는지 확인 (버튼 눌렀을 때만 작동)
  if (@form['myfile']):
    @res = file.upload(@form['myfile'])
               .path("/uploads")
               .allow("jpg,png,gif")
               .save();

    if (@res):
      print("<div style='color:blue; padding:10px; border:2px solid blue;'>");
      print("✅ <b>검거 성공!</b><br>");
      print("📍 최종 파일명: " . @res . "<br>");
      print("📂 저장 경로: /www/uploads/" . @res);
      print("</div>");
    else:
      print("<div style='color:red;'>❌ <b>검거 실패:</b> 수사 조건(확장자/용량)을 위반했거나 파일이 없습니다.</div>");
    endif;
  else:
    print("<p>👇 아래 폼에서 파일을 선택하고 수사를 시작하세요.</p>");
  endif;
]]

<hr>
<!-- 실제 파일을 던져줄 취조실(Form) -->
<form method="post" enctype="multipart/form-data" style="padding:20px; background:#f4f4f4; border:1px solid #ccc;">
    <input type="file" name="myfile" style="margin-bottom:10px;"><br>
    <button type="submit" style="padding:10px 20px; cursor:pointer; background:#000; color:#fff; border:none;">
        🚨 수사 개시 (Upload)
    </button>
</form>