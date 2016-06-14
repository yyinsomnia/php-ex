<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 5/15/16
 * Time: 00:28
 */


$a = [0 => 'facebook', 1 => 'linkedin', 'google', 'amazon'];
$a = new stdClass();
//$a->4 = 's'; //Fatal error
$a->liu = 'qq'; //yeah
$j = json_encode($a);
echo $j;