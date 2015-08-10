<?php

$str1 = decbin(E_ALL);
$str2 = decbin(E_DEPRECATED);

echo $str1, '<br />', $str2;

echo '<br />';
printf("%032b", E_ALL);
echo '<br />';
printf("%032b", E_DEPRECATED);