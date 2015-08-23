<?php
ini_set('session.save_handler', 'memcache');
ini_set('session.save_path', 'tcp://127.0.0.1:11211');
ini_set('session.gc_maxlifetime', 1440);


session_start();

$_SESSION['uid'] = 2002;
//session_write_close();
sleep(5);

$a = $_SESSION['uid'];
var_dump($a);