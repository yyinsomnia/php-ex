<?php

$str1 = '我们都是中国人';
$str2 = '我们都爱我们的祖国';

var_dump(levenshtein($str1, $str2));