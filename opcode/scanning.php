<?php
	
$source = file_get_contents(__DIR__.'/demo.php');

print_r(token_get_all($source));

