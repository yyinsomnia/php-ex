<?php


echo strtotime("2015-07-01 07:59:60");
echo "<br />";
echo strtotime("2015-07-01 08:00:00");

echo "<br />";
echo date("Y-m-d H:i:s", strtotime("-2 second", strtotime("2015-07-01 08:00:00"))); //obvirously the two time use the same timestamp

echo "<br />";

$end = new DateTime("2015-07-01 08:00:00");
$start = $end->sub(new DateInterval('PT2S'));
echo $start->format('Y-m-d h:i:s'); //no difference..
