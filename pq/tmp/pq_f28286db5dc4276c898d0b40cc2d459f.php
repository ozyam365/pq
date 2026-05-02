<?php
db()->connect();

$res = db()->users->filter(function($row) {
    return $row->age > 30;
});

pq_print($res);