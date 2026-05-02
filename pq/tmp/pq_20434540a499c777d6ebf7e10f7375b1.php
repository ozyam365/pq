<?php
db()->connect();

// 유저들 가져오기
$users = db()->users->limit(1, 10);

// 데이터 가공 (이름 뒤에 '님' 붙이고, 나이에 '세' 붙이기)
$display = pq_map($users, function($row) {
    $row->name = $row->name . "님";
    $row->age = $row->age . "세";
    return $row;
});

pq_print($display);