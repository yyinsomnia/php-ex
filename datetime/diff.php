<?php


$dStart = strtotime('2015-06-30');
$dEnd   = strtotime('2015-07-02');
$dDiff  = $dEnd - $dStart;
echo $dDiff;

echo "<br />";



$dStart = new DateTime('2015-06-30');
$dEnd = new DateTime('2015-07-02');
$dDiff = $dEnd->diff($dStart);
echo $dDiff->format("%a");