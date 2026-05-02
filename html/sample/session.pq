[[ 
    // 1. [기록] 시스템 예약어 session에 직접 데이터 투옥
    session.user_id = "agent_007";
    session.login_time = date.full;
    session.level = "Top Secret";

    print("🕵️ 수사관 세션 기록 완료!");
]]

<div class="card mt-4 shadow-sm border-0">
    <div class="card-header bg-dark text-white">
        📡 실시간 세션 감식 리포트
    </div>
    <div class="card-body bg-light">
        [[ 
            // 2. [소환] 세션 정보를 변수(@)에 할당하여 수사 진행
            @uid = session.user_id;
            @time = session.login_time;
            
            if(@uid) {
                print("<div class='mb-2'><b>접속 요원:</b> " . @uid . "</div>");
                print("<div class='mb-2'><b>침투 시간:</b> " . @time . "</div>");
                print("<div class='mb-0'><b>보안 등급:</b> <span class='badge bg-danger'>" . session.level . "</span></div>");
            } else {
                print("<div class='alert alert-warning mb-0'>⚠️ 탐지된 세션 정보가 없습니다.</div>");
            }
        ]]
    </div>
</div>

<div class="mt-4">
    [[ 
        // 3. [소탕] 로그아웃 버튼 클릭 시 session.clear() 집행 로직 (예시)
        if(form.logout == "true") {
            session.clear();
            http.redirect("/intro");
        }
    ]]
    <a href="?logout=true" class="btn btn-outline-danger btn-sm">
        <i class="bi bi-door-open"></i> 수사 종료 (Logout)
    </a>
</div>
