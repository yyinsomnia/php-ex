<?php

$password_hash = password_hash(
	$_POST['password'],
	PASSWORD_DEFAULT,
	['cost' => 10] // 200ms+ when set to 12, 60ms+ when set 10
);

echo $password_hash;

var_dump(password_verify($_POST['password'], $password_hash));