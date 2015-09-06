<?php


preg_match("#\w*#", "苹果", $match); //can't match

preg_match("#\w*#", "halo  asa", $match);

var_dump($match);