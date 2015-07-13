<?php
ini_set('memory_limit', '512M');



$set1 = range(4000000, 5000000);
$set2 = range(4000000, 4800000);

$start_time = microtime(true);
$res = array_diff($set1, $set2);
// result: 6.630s, 374M



$set1 = array_fill(4000000, 1000000, true);
$set2 = array_fill(4000000, 999999, true);
$start_time = microtime(true);
$res = array_diff_key($set1, $set2);
// result: 0.013s, 194M
















echo microtime(true) - $start_time;
echo "\n";
echo memory_get_peak_usage(true);