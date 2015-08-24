<?php

$foo = 5 + "10 Little Piggies";
var_dump($foo); // int 15

$foo = 5 + "10Little Piggies";
var_dump($foo); // int 15

$str = '01001';
$binary = (binary) $str;
var_dump($binary); // string '01001' (length=5)
$binary = b"10001000";
var_dump($binary); // string '10001000' (length=8)