<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 1/10/16
 * Time: 15:59
 */

$n = 60000;
$min = 1;
$max = 6;
$len = $max - $min + 1;

//srand(1);

$result = array_fill($min, $len, 0);

for ($i = 0 ; $i < $n; $i++) {
    $result[mt_rand($min, $max)]++;
}

$sum = 0;
foreach ($result as $value => $count) {
    $sum += pow($count, 2);
}

$v = $sum / $n - $n / $len;


print_r($result);
echo $v, PHP_EOL;