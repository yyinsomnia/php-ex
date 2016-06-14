<?php

class A
{
	public $a = 5 * 10;
}

$o = new A();
var_dump($o); //Parse error: syntax error, unexpected '*', expecting ',' or ';' 