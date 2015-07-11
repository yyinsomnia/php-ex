<?php

$string   = '你好';

print_r(preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY));