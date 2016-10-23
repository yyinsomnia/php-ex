<?php

function fibonacci_fast($i) {
	static $res;

	if (isset($res[$i])) {
		return $res[$i];
	} else {
		if ($i == 0) {
			$res[0] = 0;
			return 0;
		} elseif ($i == 1) {
			$res[1] = 1;
			return 1;
		} else {
			$res[$i] = fibonacci($i - 1) + fibonacci($i - 2);
			return $res[$i];
		}
	}
}

function fibonacci_naive($i) {
	if ($i == 0) {
		return 0;
	} elseif ($i == 1) {
		return 1;
	} else {
		return fibonacci($i - 1) + fibonacci($i - 2);
	}
}

function fibonacci($i) {
	return fibonacci_native($i);
}

var_dump(fibonacci(30));