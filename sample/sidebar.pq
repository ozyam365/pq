<?php
// sample/sidebar.pq
trace.add("D_D", "사이드바 스캔 시작");

(@)menu_tree = pq_scan_menu();

// 뷰로 던지기
pq_view("layout/sidebar", ["tree" : (@menu_tree)]);
?>