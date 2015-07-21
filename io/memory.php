<?php


$s = 'asdfasdfasdfasdfasfaswdfaseasdfaswdfasdffa';

$path = 'php://memory';

$h = fopen($path, "rw+");
fwrite($h, "bugabuga");
fseek($h, 0);
echo stream_get_contents($h);