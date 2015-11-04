<?php


$redis = new \Redis();
$redis->connect('192.168.1.198');
$redis->select(1);
$redis->subscribe(array('car_notify'), function($message) {echo json_encode($message);exit(0);}); // subscribe to 3 chans