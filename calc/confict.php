<?php
/**
 * 1 second 100 times write
 * Created by PhpStorm.
 * User: leo
 * Date: 1/10/16
 * Time: 16:29
 */

$res = 1;
$n = 10;
$end = 1000 - $n;

for ($i = 1000; $i > $end; $i--) {
    $res *= $i / 1000;
}

var_dump($res);

