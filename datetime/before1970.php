<?php

$objDateTime = new \DateTime('-200000 days');
echo $objDateTime->format('Y-m-d');
echo "\n";
echo strtotime('1840-01-01');