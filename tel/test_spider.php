<?php

require __DIR__ . '/Spider.php';

$s = new Dim_Tel_Spider('http://baike.baidu.com/view/10305397.htm');
var_dump($s->getTelDict());