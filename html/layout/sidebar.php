<?php
// 현재 접속한 URI를 가져옵니다 (예: /db/connect)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 어떤 그룹을 자동으로 열어둘지 판별
$is_db    = (strpos($uri, '/db/') !== false);
$is_file  = (strpos($uri, '/file/') !== false);
$is_http    = (strpos($uri, '/http/') !== false);
$is_session    = (strpos($uri, '/session/') !== false);
$is_date  = (strpos($uri, '/date/') !== false);
$is_form  = (strpos($uri, '/form/') !== false);
$is_text  = (strpos($uri, '/text/') !== false);
$is_api   = (strpos($uri, '/api/') !== false);
?>
<div class="pq-sidebar">
    <!-- 로고 영역 -->
    <div class="pq-sidebar-top">
        <a href="/"><img src="/html/layout/img/pq_logo.png" class="pq-logo-img"></a>
        <br><span class="pq-version-badge">Version 1.3.1 beta</span>
    </div>

    <!-- 대시보드 -->
    <a href="/lab" class="nav-dashboard">
        <i class="bi bi-compass me-2"></i> <b>Police Line</b>
    </a>

    <!-- [CORE PAGES] -->
    <div class="nav-category-static">Core Pages</div>

    <!-- DB function -->
    <div class="nav-sub-group <?= $is_db ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#db-items" aria-expanded="<?= $is_db ? 'true' : 'false' ?>">
        <span><i class="bi bi-database me-2"></i>DB function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_db ? 'show' : '' ?>" id="db-items">
        <ul class="sub-menu">
            <!-- 현재 페이지면 active 클래스 추가 / 완료됐으면 pq-dot 유지 -->
            <li><a href="/db/chain" class="nav-link-pq <?= ($uri == '/db/chain') ? 'active' : '' ?>">CHAIN PATTERN<span class="pq-dot"></span></a></li>
			<li><a href="/db/connect" class="nav-link-pq <?= ($uri == '/db/connect') ? 'active' : '' ?>">connect(); <span class="pq-dot"></span></a></li>
            <li><a href="/db/query" class="nav-link-pq <?= ($uri == '/db/query') ? 'active' : '' ?>">query(); <span class="pq-dot"></span></a></li>
            <li><a href="/db/insert" class="nav-link-pq <?= ($uri == '/db/insert') ? 'active' : '' ?>">insert(); <span class="pq-dot"></span></a></li>
            <li><a href="/db/where" class="nav-link-pq <?= ($uri == '/db/where') ? 'active' : '' ?>">where(); <span class="pq-dot"></span></a></li>
            <li><a href="/db/update" class="nav-link-pq <?= ($uri == '/db/update') ? 'active' : '' ?>">update(); <span class="pq-dot"></span></a></li>
            <li><a href="/db/delete" class="nav-link-pq <?= ($uri == '/db/delete') ? 'active' : '' ?>">delete(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/sort" class="nav-link-pq <?= ($uri == '/db/sort') ? 'active' : '' ?>">sort(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/limit" class="nav-link-pq <?= ($uri == '/db/limit') ? 'active' : '' ?>">limit(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/one" class="nav-link-pq <?= ($uri == '/db/one') ? 'active' : '' ?>">one(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/cnt" class="nav-link-pq <?= ($uri == '/db/cnt') ? 'active' : '' ?>">cnt(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/has" class="nav-link-pq <?= ($uri == '/db/has') ? 'active' : '' ?>">has(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/make" class="nav-link-pq <?= ($uri == '/db/make') ? 'active' : '' ?>">make(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/clear" class="nav-link-pq <?= ($uri == '/db/clear') ? 'active' : '' ?>">clear(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/join" class="nav-link-pq <?= ($uri == '/db/join') ? 'active' : '' ?>">join(); <span class="pq-dot"></span></a></li>						
            <li><a href="/db/pluck" class="nav-link-pq <?= ($uri == '/db/pluck') ? 'active' : '' ?>">pluck(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/when" class="nav-link-pq <?= ($uri == '/db/when') ? 'active' : '' ?>">when(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/and" class="nav-link-pq <?= ($uri == '/db/and') ? 'active' : '' ?>">and(); <span class="pq-dot"></span></a></li>			
            <li><a href="/db/or" class="nav-link-pq <?= ($uri == '/db/or') ? 'active' : '' ?>">or(); <span class="pq-dot"></span></a></li>	
			<li><a href="/db/like" class="nav-link-pq <?= ($uri == '/db/like') ? 'active' : '' ?>">like(); <span class="pq-dot"></span></a></li>				
        </ul>
    </div>

    <!-- FILE function -->
    <div class="nav-sub-group <?= $is_file ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#file-items" aria-expanded="<?= $is_file ? 'true' : 'false' ?>">
        <span><i class="bi bi-file me-2"></i>FILE function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_file ? 'show' : '' ?>" id="file-items">
        <ul class="sub-menu">
            <li><a href="/file/chain" class="nav-link-pq <?= ($uri == '/file/chain') ? 'active' : '' ?>">CHAIN PATTERN<span class="pq-dot"></span></a></li>
            <li class="sub-title"> [ Upload function ]</li>			
            <li><a href="/file/upload" class="nav-link-pq <?= ($uri == '/file/upload') ? 'active' : '' ?>">upload();<span class="pq-dot"></span></a></li>
            <li><a href="/file/path" class="nav-link-pq <?= ($uri == '/file/path') ? 'active' : '' ?>">path();<span class="pq-dot"></span></a></li>
            <li><a href="/file/allow" class="nav-link-pq <?= ($uri == '/file/allow') ? 'active' : '' ?>">allow();<span class="pq-dot"></span></a></li>
            <li><a href="/file/limit" class="nav-link-pq <?= ($uri == '/file/limit') ? 'active' : '' ?>">limit();<span class="pq-dot"></span></a></li>
            <li><a href="/file/rename" class="nav-link-pq <?= ($uri == '/file/rename') ? 'active' : '' ?>">rename();<span class="pq-dot"></span></a></li>
            <li><a href="/file/random" class="nav-link-pq <?= ($uri == '/file/random') ? 'active' : '' ?>">random();<span class="pq-dot"></span></a></li>
            <li><a href="/file/image" class="nav-link-pq <?= ($uri == '/file/image') ? 'active' : '' ?>">image();<span class="pq-dot"></span></a></li>			
            <li><a href="/file/save" class="nav-link-pq <?= ($uri == '/file/save') ? 'active' : '' ?>">save();<span class="pq-dot"></span></a></li>						
            <li class="sub-title"> [ File function ]</li>			
            <li><a href="/file/read" class="nav-link-pq <?= ($uri == '/file/read') ? 'active' : '' ?>">read();<span class="pq-dot"></span></a></li>
            <li><a href="/file/write" class="nav-link-pq <?= ($uri == '/file/write') ? 'active' : '' ?>">write();<span class="pq-dot"></span></a></li>
            <li><a href="/file/append" class="nav-link-pq <?= ($uri == '/file/append') ? 'active' : '' ?>">append();<span class="pq-dot"></span></a></li>
            <li><a href="/file/has" class="nav-link-pq <?= ($uri == '/file/has') ? 'active' : '' ?>">has();<span class="pq-dot"></span></a></li>
            <li><a href="/file/delete" class="nav-link-pq <?= ($uri == '/file/delete') ? 'active' : '' ?>">delete();<span class="pq-dot"></span></a></li>
            <li><a href="/file/copy" class="nav-link-pq <?= ($uri == '/file/copy') ? 'active' : '' ?>">copy();<span class="pq-dot"></span></a></li>
            <li><a href="/file/move" class="nav-link-pq <?= ($uri == '/file/move') ? 'active' : '' ?>">move();<span class="pq-dot"></span></a></li>			
            <li><a href="/file/touch" class="nav-link-pq <?= ($uri == '/file/touch') ? 'active' : '' ?>">touch();<span class="pq-dot"></span></a></li>	
            <li class="sub-title"> [ Directory function ]</li>			
            <li><a href="/file/mkdir" class="nav-link-pq <?= ($uri == '/file/mkdir') ? 'active' : '' ?>">mkdir();<span class="pq-dot"></span></a></li>
            <li><a href="/file/listdir" class="nav-link-pq <?= ($uri == '/file/listdir') ? 'active' : '' ?>">listdir();<span class="pq-dot"></span></a></li>
            <li><a href="/file/scan" class="nav-link-pq <?= ($uri == '/file/scan') ? 'active' : '' ?>">scan();<span class="pq-dot"></span></a></li>
            <li><a href="/file/clear" class="nav-link-pq <?= ($uri == '/file/clear') ? 'active' : '' ?>">clear();<span class="pq-dot"></span></a></li>
            <li class="sub-title"> [ Info function ]</li>			
            <li><a href="/file/size" class="nav-link-pq <?= ($uri == '/file/size') ? 'active' : '' ?>">size();<span class="pq-dot"></span></a></li>
            <li><a href="/file/ext" class="nav-link-pq <?= ($uri == '/file/ext') ? 'active' : '' ?>">ext();<span class="pq-dot"></span></a></li>
            <li><a href="/file/name" class="nav-link-pq <?= ($uri == '/file/name') ? 'active' : '' ?>">name();<span class="pq-dot"></span></a></li>
            <li><a href="/file/dir" class="nav-link-pq <?= ($uri == '/file/dir') ? 'active' : '' ?>">dir();<span class="pq-dot"></span></a></li>
            <li><a href="/file/mimeType" class="nav-link-pq <?= ($uri == '/file/mimeType') ? 'active' : '' ?>">mimeType();<span class="pq-dot"></span></a></li>
            <li><a href="/file/modified" class="nav-link-pq <?= ($uri == '/file/modified') ? 'active' : '' ?>">modified();<span class="pq-dot"></span></a></li>
            <li><a href="/file/safeName" class="nav-link-pq <?= ($uri == '/file/safeName') ? 'active' : '' ?>">safeName();<span class="pq-dot"></span></a></li>	
            <li class="sub-title"> [ Output function ]</li>			
            <li><a href="/file/download" class="nav-link-pq <?= ($uri == '/file/download') ? 'active' : '' ?>">download();<span class="pq-dot"></span></a></li>
            <li><a href="/file/inline" class="nav-link-pq <?= ($uri == '/file/inline') ? 'active' : '' ?>">inline();<span class="pq-dot"></span></a></li>
            <li><a href="/file/stream" class="nav-link-pq <?= ($uri == '/file/stream') ? 'active' : '' ?>">stream();<span class="pq-dot"></span></a></li>
            <li><a href="/file/url" class="nav-link-pq <?= ($uri == '/file/url') ? 'active' : '' ?>">url();<span class="pq-dot"></span></a></li>		
        </ul>
    </div>
    <!-- HTTP function -->
    <div class="nav-sub-group <?= $is_http ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#http-items" aria-expanded="<?= $is_http ? 'true' : 'false' ?>">
        <span><i class="bi bi-browser-chrome me-2"></i>HTTP function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_http ? 'show' : '' ?>" id="http-items">
        <ul class="sub-menu">
            <li><a href="/http/chain" class="nav-link-pq <?= ($uri == '/http/chain') ? 'active' : '' ?>">CHAIN PATTERN<span class="pq-dot"></span></a></li>		
            <li><a href="/http/get" class="nav-link-pq <?= ($uri == '/http/get') ? 'active' : '' ?>">get();<span class="pq-dot"></span></a></li>
            <li><a href="/http/post" class="nav-link-pq <?= ($uri == '/http/post') ? 'active' : '' ?>">post();<span class="pq-dot"></span></a></li>
            <li><a href="/http/put" class="nav-link-pq <?= ($uri == '/http/put') ? 'active' : '' ?>">put();<span class="pq-dot"></span></a></li>
            <li><a href="/http/delete" class="nav-link-pq <?= ($uri == '/http/delete') ? 'active' : '' ?>">delete();<span class="pq-dot"></span></a></li>
            <li><a href="/http/header" class="nav-link-pq <?= ($uri == '/http/header') ? 'active' : '' ?>">header();<span class="pq-dot"></span></a></li>
            <li><a href="/http/timeout" class="nav-link-pq <?= ($uri == '/http/timeout') ? 'active' : '' ?>">timeout();<span class="pq-dot"></span></a></li>
            <li><a href="/http/json" class="nav-link-pq <?= ($uri == '/http/json') ? 'active' : '' ?>">json();<span class="pq-dot"></span></a></li>
            <li><a href="/http/all" class="nav-link-pq <?= ($uri == '/http/all') ? 'active' : '' ?>">all();<span class="pq-dot"></span></a></li>
            <li><a href="/http/safe" class="nav-link-pq <?= ($uri == '/http/safe') ? 'active' : '' ?>">safe();<span class="pq-dot"></span></a></li>
            <li><a href="/http/redirect" class="nav-link-pq <?= ($uri == '/http/redirect') ? 'active' : '' ?>">redirect();<span class="pq-dot"></span></a></li>			
        </ul>
    </div>
    <!-- SESSION function -->
    <div class="nav-sub-group <?= $is_session ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#session-items" aria-expanded="<?= $is_session ? 'true' : 'false' ?>">
        <span><i class="bi bi-door-open me-2"></i>SESSION function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_session ? 'show' : '' ?>" id="session-items">
        <ul class="sub-menu">
            <li><a href="/session/chain" class="nav-link-pq <?= ($uri == '/session/chain') ? 'active' : '' ?>">CHAIN PATTERN<span class="pq-dot"></span></a></li>		
            <li><a href="/session/set" class="nav-link-pq <?= ($uri == '/session/set') ? 'active' : '' ?>">set();<span class="pq-dot"></span></a></li>
            <li><a href="/session/get" class="nav-link-pq <?= ($uri == '/session/get') ? 'active' : '' ?>">get();<span class="pq-dot"></span></a></li>
            <li><a href="/session/all" class="nav-link-pq <?= ($uri == '/session/all') ? 'active' : '' ?>">all();<span class="pq-dot"></span></a></li>
            <li><a href="/session/login" class="nav-link-pq <?= ($uri == '/session/login') ? 'active' : '' ?>">login();<span class="pq-dot"></span></a></li>
            <li><a href="/session/user" class="nav-link-pq <?= ($uri == '/session/user') ? 'active' : '' ?>">user();<span class="pq-dot"></span></a></li>	
            <li><a href="/session/check" class="nav-link-pq <?= ($uri == '/session/check') ? 'active' : '' ?>">check();<span class="pq-dot"></span></a></li>					
            <li><a href="/session/auth" class="nav-link-pq <?= ($uri == '/session/auth') ? 'active' : '' ?>">auth();<span class="pq-dot"></span></a></li>			
			<li><a href="/session/guard" class="nav-link-pq <?= ($uri == '/session/guard') ? 'active' : '' ?>">guard();<span class="pq-dot"></span></a></li>
            <li><a href="/session/flash" class="nav-link-pq <?= ($uri == '/session/flash') ? 'active' : '' ?>">flash();<span class="pq-dot"></span></a></li>
            <li><a href="/session/hasFlash" class="nav-link-pq <?= ($uri == '/session/hasFlash') ? 'active' : '' ?>">hasFlash();<span class="pq-dot"></span></a></li>
            <li><a href="/session/clear" class="nav-link-pq <?= ($uri == '/session/clear') ? 'active' : '' ?>">clear();<span class="pq-dot"></span></a></li>
			<li><a href="/session/destroy" class="nav-link-pq <?= ($uri == '/session/destroy') ? 'active' : '' ?>">destroy();<span class="pq-dot"></span></a></li>
        </ul>				
    </div>	
    <div class="nav-sub-group <?= $is_form ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#form-items" aria-expanded="<?= $is_form ? 'true' : 'false' ?>">
        <span><i class="bi bi-input-cursor  me-2"></i>Form function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>	
    <div class="collapse <?= $is_form ? 'show' : '' ?>" id="form-items">
        <ul class="sub-menu">		
            <li><a href="/form/chain" class="nav-link-pq <?= ($uri == '/form/chain') ? 'active' : '' ?>">CHAIN PATTERN<span class="pq-dot"></span></a></li>				
            <li><a href="/form/all" class="nav-link-pq <?= ($uri == '/form/all') ? 'active' : '' ?>">all();<span class="pq-dot"></span></a></li>
            <li><a href="/form/get" class="nav-link-pq <?= ($uri == '/form/get') ? 'active' : '' ?>">get();<span class="pq-dot"></span></a></li>
            <li><a href="/form/only" class="nav-link-pq <?= ($uri == '/form/only') ? 'active' : '' ?>">only();<span class="pq-dot"></span></a></li>
            <li><a href="/form/except" class="nav-link-pq <?= ($uri == '/form/except') ? 'active' : '' ?>">except();<span class="pq-dot"></span></a></li>
            <li><a href="/form/trim" class="nav-link-pq <?= ($uri == '/form/trim') ? 'active' : '' ?>">trim();<span class="pq-dot"></span></a></li>
            <li><a href="/form/safe" class="nav-link-pq <?= ($uri == '/form/safe') ? 'active' : '' ?>">safe();<span class="pq-dot"></span></a></li>
            <li><a href="/form/set" class="nav-link-pq <?= ($uri == '/form/set') ? 'active' : '' ?>">set();<span class="pq-dot"></span></a></li>
            <li><a href="/form/required" class="nav-link-pq <?= ($uri == '/form/required') ? 'active' : '' ?>">required();<span class="pq-dot"></span></a></li>
            <li><a href="/form/fail" class="nav-link-pq <?= ($uri == '/form/fail') ? 'active' : '' ?>">fail();<span class="pq-dot"></span></a></li>
            <li><a href="/form/errors" class="nav-link-pq <?= ($uri == '/form/errors') ? 'active' : '' ?>">errors();<span class="pq-dot"></span></a></li>
            <li><a href="/form/old" class="nav-link-pq <?= ($uri == '/form/old') ? 'active' : '' ?>">old();<span class="pq-dot"></span></a></li>
            <li><a href="/form/clearOld" class="nav-link-pq <?= ($uri == '/form/clearOld') ? 'active' : '' ?>">clearOld();<span class="pq-dot"></span></a></li>						
        </ul>
    </div>	
    <div class="nav-sub-group <?= $is_date ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#date-items" aria-expanded="<?= $is_date ? 'true' : 'false' ?>">
        <span><i class="bi bi-calendar-check me-2"></i>Date function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_date ? 'show' : '' ?>" id="date-items">
        <ul class="sub-menu">
            <li><a href="/date/chain" class="nav-link-pq <?= ($uri == '/date/chain') ? 'active' : '' ?>">CHAIN PATTERN<span class="pq-dot"></span></a></li>				
            <li><a href="/date/parse" class="nav-link-pq <?= ($uri == '/date/parse') ? 'active' : '' ?>">parse();<span class="pq-dot"></span></a></li>
            <li><a href="/date/now" class="nav-link-pq <?= ($uri == '/date/now') ? 'active' : '' ?>">now();<span class="pq-dot"></span></a></li>
            <li><a href="/date/today" class="nav-link-pq <?= ($uri == '/date/today') ? 'active' : '' ?>">today();<span class="pq-dot"></span></a></li>
            <li><a href="/date/year" class="nav-link-pq <?= ($uri == '/date/year') ? 'active' : '' ?>">year();<span class="pq-dot"></span></a></li>
            <li><a href="/date/month" class="nav-link-pq <?= ($uri == '/date/month') ? 'active' : '' ?>">month();<span class="pq-dot"></span></a></li>
            <li><a href="/date/day" class="nav-link-pq <?= ($uri == '/date/day') ? 'active' : '' ?>">day();<span class="pq-dot"></span></a></li>
            <li><a href="/date/week" class="nav-link-pq <?= ($uri == '/date/week') ? 'active' : '' ?>">week();<span class="pq-dot"></span></a></li>			
            <li><a href="/date/timestamp" class="nav-link-pq <?= ($uri == '/date/timestamp') ? 'active' : '' ?>">timestamp();<span class="pq-dot"></span></a></li>
            <li><a href="/date/format" class="nav-link-pq <?= ($uri == '/date/format') ? 'active' : '' ?>">format();<span class="pq-dot"></span></a></li>
            <li><a href="/date/addYear" class="nav-link-pq <?= ($uri == '/date/addYear') ? 'active' : '' ?>">addYear();<span class="pq-dot"></span></a></li>
            <li><a href="/date/subYear" class="nav-link-pq <?= ($uri == '/date/subYear') ? 'active' : '' ?>">subYear();<span class="pq-dot"></span></a></li>			
            <li><a href="/date/addMonth" class="nav-link-pq <?= ($uri == '/date/addMonth') ? 'active' : '' ?>">addMonth();<span class="pq-dot"></span></a></li>
            <li><a href="/date/subMonth" class="nav-link-pq <?= ($uri == '/date/subMonth') ? 'active' : '' ?>">subMonth();<span class="pq-dot"></span></a></li>			
			<li><a href="/date/addDay" class="nav-link-pq <?= ($uri == '/date/addDay') ? 'active' : '' ?>">addDay();<span class="pq-dot"></span></a></li>
            <li><a href="/date/subDay" class="nav-link-pq <?= ($uri == '/date/subDay') ? 'active' : '' ?>">subDay();<span class="pq-dot"></span></a></li>
            <li><a href="/date/addHour" class="nav-link-pq <?= ($uri == '/date/addHour') ? 'active' : '' ?>">addHour();<span class="pq-dot"></span></a></li>
            <li><a href="/date/subHour" class="nav-link-pq <?= ($uri == '/date/subHour') ? 'active' : '' ?>">subHour();<span class="pq-dot"></span></a></li>
            <li><a href="/date/addMinute" class="nav-link-pq <?= ($uri == '/date/addMinute') ? 'active' : '' ?>">addMinute();<span class="pq-dot"></span></a></li>
            <li><a href="/date/subMinute" class="nav-link-pq <?= ($uri == '/date/subMinute') ? 'active' : '' ?>">subMinute();<span class="pq-dot"></span></a></li>
            <li><a href="/date/firstDay" class="nav-link-pq <?= ($uri == '/date/firstDay') ? 'active' : '' ?>">firstDay();<span class="pq-dot"></span></a></li>
            <li><a href="/date/lastDay" class="nav-link-pq <?= ($uri == '/date/lastDay') ? 'active' : '' ?>">lastDay();<span class="pq-dot"></span></a></li>
            <li><a href="/date/startOfMonth" class="nav-link-pq <?= ($uri == '/date/startOfMonth') ? 'active' : '' ?>">startOfMonth();<span class="pq-dot"></span></a></li>
            <li><a href="/date/endOfMonth" class="nav-link-pq <?= ($uri == '/date/endOfMonth') ? 'active' : '' ?>">endOfMonth();<span class="pq-dot"></span></a></li>			
            <li><a href="/date/diff" class="nav-link-pq <?= ($uri == '/date/diff') ? 'active' : '' ?>">diff();<span class="pq-dot"></span></a></li>						
            <li><a href="/date/isPast" class="nav-link-pq <?= ($uri == '/date/isPast') ? 'active' : '' ?>">isPast();<span class="pq-dot"></span></a></li>			
            <li><a href="/date/isFuture" class="nav-link-pq <?= ($uri == '/date/isFuture') ? 'active' : '' ?>">isFuture();<span class="pq-dot"></span></a></li>						
            <li><a href="/date/isWeekend" class="nav-link-pq <?= ($uri == '/date/isWeekend') ? 'active' : '' ?>">isWeekend();<span class="pq-dot"></span></a></li>			
			<li><a href="/date/humanize" class="nav-link-pq <?= ($uri == '/date/humanize') ? 'active' : '' ?>">humanize();<span class="pq-dot"></span></a></li>									
        </ul>
    </div>
    <div class="nav-sub-group <?= $is_text ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#text-items" aria-expanded="<?= $is_text ? 'true' : 'false' ?>">
        <span><i class="bi bi-blockquote-left me-2"></i>Text function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_text ? 'show' : '' ?>" id="text-items">
        <ul class="sub-menu">
            <li><a href="/text/chain" class="nav-link-pq <?= ($uri == '/text/chain') ? 'active' : '' ?>">CHAIN PATTERN<span class="pq-dot"></span></a></li>						
            <li><a href="/text/upper" class="nav-link-pq <?= ($uri == '/text/upper') ? 'active' : '' ?>">upper();<span class="pq-dot"></span></a></li>
            <li><a href="/text/length" class="nav-link-pq <?= ($uri == '/text/length') ? 'active' : '' ?>">length();<span class="pq-dot"></span></a></li>			
            <li><a href="/text/cut" class="nav-link-pq <?= ($uri == '/text/cut') ? 'active' : '' ?>">cut();<span class="pq-dot"></span></a></li>
            <li><a href="/text/contains" class="nav-link-pq <?= ($uri == '/text/contains') ? 'active' : '' ?>">contains();<span class="pq-dot"></span></a></li>
            <li><a href="/text/replace" class="nav-link-pq <?= ($uri == '/text/replace') ? 'active' : '' ?>">replace();<span class="pq-dot"></span></a></li>
            <li><a href="/text/split" class="nav-link-pq <?= ($uri == '/text/split') ? 'active' : '' ?>">split();<span class="pq-dot"></span></a></li>
            <li><a href="/text/join" class="nav-link-pq <?= ($uri == '/text/join') ? 'active' : '' ?>">join();<span class="pq-dot"></span></a></li>
            <li><a href="/text/isEmail" class="nav-link-pq <?= ($uri == '/text/isEmail') ? 'active' : '' ?>">isEmail();<span class="pq-dot"></span></a></li>
            <li><a href="/text/isUrl" class="nav-link-pq <?= ($uri == '/text/isUrl') ? 'active' : '' ?>">isUrl();<span class="pq-dot"></span></a></li>
            <li><a href="/text/slug" class="nav-link-pq <?= ($uri == '/text/slug') ? 'active' : '' ?>">slug();<span class="pq-dot"></span></a></li>
            <li><a href="/text/escapeHtml" class="nav-link-pq <?= ($uri == '/text/escapeHtml') ? 'active' : '' ?>">escapeHtml();<span class="pq-dot"></span></a></li>
            <li><a href="/text/random" class="nav-link-pq <?= ($uri == '/text/random') ? 'active' : '' ?>">random();<span class="pq-dot"></span></a></li>
            <li><a href="/text/uuid" class="nav-link-pq <?= ($uri == '/text/uuid') ? 'active' : '' ?>">uuid();<span class="pq-dot"></span></a></li>
            <li><a href="/text/format" class="nav-link-pq <?= ($uri == '/text/format') ? 'active' : '' ?>">format();<span class="pq-dot"></span></a></li>	
        </ul>
    </div>		
    <div class="nav-sub-group <?= $is_excel ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#excel-items" aria-expanded="<?= $is_excel ? 'true' : 'false' ?>">
        <span><i class="bi bi-file-earmark-spreadsheet me-2"></i>Excel function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_excel ? 'show' : '' ?>" id="excel-items">
        <ul class="sub-menu">
            <li><a href="/date/now" class="nav-link-pq <?= ($uri == '/date/now') ? 'active' : '' ?>">now(); <span class="pq-dot"></span></a></li>
            <li><a href="/date/format" class="nav-link-pq <?= ($uri == '/date/format') ? 'active' : '' ?>">format();</a></li>
        </ul>
    </div>
    <div class="nav-sub-group <?= $is_pdf ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#excel-items" aria-expanded="<?= $is_pdf ? 'true' : 'false' ?>">
        <span><i class="bi bi-filetype-pdf me-2"></i>Pdf function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_pdf ? 'show' : '' ?>" id="excel-items">
        <ul class="sub-menu">
            <li><a href="/pdf/now" class="nav-link-pq <?= ($uri == '/pdf/read') ? 'active' : '' ?>">read(); <span class="pq-dot"></span></a></li>
            <li><a href="/pdf/format" class="nav-link-pq <?= ($uri == '/pdf/format') ? 'active' : '' ?>">write();</a></li>
        </ul>
    </div>		
    <!-- [Plugin PAGES] -->
    <div class="nav-category-static">Plugin Pages</div>	
    <div class="nav-sub-group <?= $is_qrcode ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#qrcode-items" aria-expanded="<?= $is_qrcode ? 'true' : 'false' ?>">
        <span><i class="bi bi bi-qr-code me-2"></i>Qrcode function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_qrcode ? 'show' : '' ?>" id="qrcode-items">
        <ul class="sub-menu">
            <li><a href="/date/now" class="nav-link-pq <?= ($uri == '/date/now') ? 'active' : '' ?>">read(); <span class="pq-dot"></span></a></li>
            <li><a href="/date/format" class="nav-link-pq <?= ($uri == '/date/format') ? 'active' : '' ?>">write();</a></li>
        </ul>
    </div>
    <div class="nav-sub-group <?= $is_barcode ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#qrcode-items" aria-expanded="<?= $is_barcode ? 'true' : 'false' ?>">
        <span><i class="bi bi bi-upc me-2"></i>Barcode function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_barcode ? 'show' : '' ?>" id="qrcode-items">
        <ul class="sub-menu">
            <li><a href="/date/now" class="nav-link-pq <?= ($uri == '/date/now') ? 'active' : '' ?>">read(); <span class="pq-dot"></span></a></li>
            <li><a href="/date/format" class="nav-link-pq <?= ($uri == '/date/format') ? 'active' : '' ?>">write();</a></li>
        </ul>
    </div>	

    <!-- Api function -->
    <div class="nav-sub-group <?= $is_api ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#api-items" aria-expanded="<?= $is_api ? 'true' : 'false' ?>">
        <span><i class="bi bi-globe-central-south-asia me-2"></i>Api function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_api ? 'show' : '' ?>" id="api-items">
        <ul class="sub-menu">
            <li><a href="/api/now" class="nav-link-pq <?= ($uri == '/api/now') ? 'active' : '' ?>">now(); <span class="pq-dot"></span></a></li>
            <li><a href="/api/format" class="nav-link-pq <?= ($uri == '/api/format') ? 'active' : '' ?>">format();</a></li>
        </ul>
    </div>	
    <div class="nav-sub-group <?= $is_app ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#app-items" aria-expanded="<?= $is_app ? 'true' : 'false' ?>">
        <span><i class="bi bi-android me-2"></i>App function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_app ? 'show' : '' ?>" id="app-items">
        <ul class="sub-menu">
            <li><a href="/app/now" class="nav-link-pq <?= ($uri == '/app/now') ? 'active' : '' ?>">now(); <span class="pq-dot"></span></a></li>
            <li><a href="/app/format" class="nav-link-pq <?= ($uri == '/app/format') ? 'active' : '' ?>">format();</a></li>
        </ul>
    </div>		
    <div class="nav-sub-group <?= $is_chat ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#chat-items" aria-expanded="<?= $is_chat ? 'true' : 'false' ?>">
        <span><i class="bi bi-chat-dots me-2"></i>Chat function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_chat ? 'show' : '' ?>" id="chat-items">
        <ul class="sub-menu">
            <li><a href="/chat /now" class="nav-link-pq <?= ($uri == '/chat /now') ? 'active' : '' ?>">now(); <span class="pq-dot"></span></a></li>
            <li><a href="/chat /format" class="nav-link-pq <?= ($uri == '/chat /format') ? 'active' : '' ?>">format();</a></li>
        </ul>
    </div>		
    <div class="nav-sub-group <?= $is_iot ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#iot-items" aria-expanded="<?= $is_iot ? 'true' : 'false' ?>">
        <span><i class="bi bi-plugin me-2"></i>Iot function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_iot ? 'show' : '' ?>" id="iot-items">
        <ul class="sub-menu">
            <li><a href="/iot/now" class="nav-link-pq <?= ($uri == '/iot/now') ? 'active' : '' ?>">now(); <span class="pq-dot"></span></a></li>
            <li><a href="/iot/format" class="nav-link-pq <?= ($uri == '/iot/format') ? 'active' : '' ?>">format();</a></li>
        </ul>
    </div>		
    <div class="nav-sub-group <?= $is_auto ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#ai-items" aria-expanded="<?= $is_auto ? 'true' : 'false' ?>">
        <span><i class="bi bi-broadcast-pin  me-2"></i>Auto function</span>
        <i class="bi bi-chevron-down chevron-icon"></i>
    </div>
    <div class="collapse <?= $is_auto ? 'show' : '' ?>" id="ai-items">
        <ul class="sub-menu">
            <li><a href="/auto/now" class="nav-link-pq <?= ($uri == '/auto/now') ? 'active' : '' ?>">now(); <span class="pq-dot"></span></a></li>
            <li><a href="/auto/format" class="nav-link-pq <?= ($uri == '/auto/format') ? 'active' : '' ?>">format();</a></li>
        </ul>
    </div>		
	
	<div class="mb-5">
	</div>
</div>
