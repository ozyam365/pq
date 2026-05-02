<?php
// 현재 접속한 주소 (예: /intro/index)
$current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!-- html/layout/sidebar.php -->
<nav class="col-md-3 col-lg-2 pq-sidebar px-0 border-end" style="background-color: #f6f8fa; border-color: #d0d7de !important; min-height: 100vh;">
    <div class="position-sticky pt-3">
        <!-- 로고 영역 -->
        <div class="px-3 mb-4">
            <a href="/" class="text-decoration-none d-flex align-items-center" style="color: #0969da;">
                <svg height="24" viewBox="0 0 16 16" width="24" class="me-2" fill="currentColor">
                    <path d="M8 0c4.42 0 8 3.58 8 8a8.013 8.013 0 0 1-5.45 7.59c-.4.08-.55-.17-.55-.38 0-.27.01-1.13.01-2.2 0-.75-.25-1.23-.54-1.48 1.78-.2 3.65-.88 3.65-3.95 0-.88-.31-1.59-.82-2.15.08-.2.36-1.02-.08-2.12 0 0-.67-.22-2.2.82-.64-.18-1.32-.27-2-.27-.68 0-1.36.09-2 .27-1.53-1.03-2.2-.82-2.2-.82-.44 1.1-.16 1.92-.08 2.12-.51.56-.82 1.28-.82 2.15 0 3.06 1.86 3.75 3.64 3.95-.23.2-.44.55-.51 1.07-.46.21-1.61.55-2.33-.66-.15-.24-.6-.83-1.23-.82-.67.01-.27.38.01.53.34.19.73.9.82 1.13.16.45.68 1.31 2.69.94 0 .67.01 1.3.01 1.49 0 .21-.15.45-.55.38A7.995 7.995 0 0 1 0 8c0-4.42 3.58-8 8-8Z"></path>
                </svg>
                <span class="fs-5 fw-bold">PQ Engine</span>
            </a>
        </div>

        <!-- 메뉴 목록 -->
        <div class="px-2">
			<!-- html/layout/sidebar.php -->
				<ul class="nav flex-column mt-2">
					<?php 
					$menus = pq_get_menu(); 
					foreach($menus as $m): 
						// 현재 페이지와 메뉴 링크가 일치하는지 수사
						$is_active = ($current_page == $m['link']) ? true : false;
						$active_class = $is_active ? 'active-menu' : '';
					?>
					<li class="nav-item">
						<a class="nav-link py-2 px-3 mb-1 rounded-2 d-flex align-items-center <?= $active_class ?>" 
						   href="<?= $m['link'] ?>" 
						   style="color: <?= $is_active ? '#0969da' : '#24292f' ?> !important; 
								  font-weight: <?= $is_active ? '600' : '400' ?>;
								  background-color: <?= $is_active ? '#ebecf0' : 'transparent' ?>;
								  border-left: <?= $is_active ? '4px solid #0969da' : '4px solid transparent' ?>;
								  text-decoration: none !important;">
							<i class="bi <?= $is_active ? 'bi-file-earmark-text-fill' : 'bi-file-earmark-text' ?> me-2"></i> 
							<span><?= $m['name'] ?></span>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
        </div>
    </div>
</nav>

<style>
    /* 사이드바 기본 레이아웃 결착 */
    .pq-sidebar .nav-link {
        display: flex !important;
        align-items: center;
        text-decoration: none !important;
        transition: background-color 0.2s;
    }

    /* [요청 사항] 활성화되지 않은 메뉴 호버 효과 */
    .nav-link:not(.active-menu):hover { 
        background-color: #f3f4f6 !important; 
        color: #000 !important;
    }
    
    /* 성역 보호 확인용: 이 스타일 태그는 화면에 노출되지 않아야 합니다. */
</style>