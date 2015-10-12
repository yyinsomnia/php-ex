<?php



function fibinacii()
{
	$a = 0;
	$b = 1;
	yield $a;
	for ($i = 2; $i < 99; $i++) {
		$tmp = $b;
		$b = $a + $b;
		$a = $tmp;
		yield $a;
	}
}

foreach (fibinacii() as $i) {
	echo $i,PHP_EOL;
}