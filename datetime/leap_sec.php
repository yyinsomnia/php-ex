<?php


echo strtotime("2015-07-01 07:59:60");
echo "<br />";
echo strtotime("2015-07-01 08:00:00");
echo "<br />";
echo strtotime("2015-07-01 08:59:60");
echo "<br />";
echo strtotime("2015-07-01 09:00:00"); //e it don't find the leap second...
echo "<br />";

echo "<br />";
echo date("Y-m-d H:i:s", strtotime("-2 second", strtotime("2015-07-01 08:00:00"))); //obviously the two time use the same timestamp

echo "<br />";

$end = new DateTime("2015-07-01 08:00:00");
$start = $end->sub(new DateInterval('PT2S'));
echo $start->format('Y-m-d h:i:s'); //no difference..
