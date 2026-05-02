[[ 
  // 1. 단일 타격 수사
  (@user) = db.user.where("id='admin'").one(); 
]]

<div class="row">
    <!-- 수사 결과 카드 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">현재 수사관</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">[[ (@user).name ]]</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-secret fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
