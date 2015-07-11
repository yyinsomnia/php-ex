<?php

ini_set('memory_limit', '4096M');

$pdo = new PDO('mysql:host=localhost;dbname=employees', 'root', '');

$sql = "SELECT car.deal_time, color.name";
$statement = $pdo->query('SELECT * FROM titles'); //why the table size: 19.6MiB but the peak in php is 98.3MiB
//while ($row = $statement->fetch(PDO::FETCH_ASSOC)){}
//$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
echo memory_get_peak_usage() / 1024 / 1024;