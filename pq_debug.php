<?php
pq_print("START");

db()->connect();

pq_print("BEFORE");

$res = pq_list("users")->page(1,10);

pq_print("AFTER");

pq_print($res);