<?php
ini_set("display_errors", "On");
/* Connect to an ODBC database using driver invocation */
$dsn = 'mysql:dbname=foundation;host=localhost';
$user = 'root';
$password = 'test';
$attrs = [PDO::ATTR_TIMEOUT => 1];

try {
    $dbh = new PDO($dsn, $user, $password);
    foreach ($attrs as $k => $v) {
    	$dbh->setAttribute($k, $v);
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$s = $dbh->query("SELECT sleep(10)"); //PDO::ATTR_TIMEOUT not worked, it's connect timeout

