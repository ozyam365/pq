trace.on  // 수사 기록 가동

// 1. 수사관 배치 및 검문 (전달된 'user_pic' 필드 수사)
(@up) = file.upload("user_pic")
            .path("/attach") // 저장될 성역 지정
            .allow("jpg, png, gif") // 허가된 신분증(확장자)
            .limit("2M")            // 몸무게(용량) 제한
            .save();                // 최종 집행

// 2. 결과 보고
if((@up).ok) {
    print "<div class='alert alert-success'>";
    print "✅ 수사 성공! 안전하게 격리되었습니다.<br>";
    print "저장된 파일명: " . (@up).name;
    print "</div>";
} else {
    print "<div class='alert alert-danger'>";
    print "❌ 수사 실패: " . (@up).error;
    print "</div>";
}