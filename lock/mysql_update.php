<?php

$dbh = new PDO('mysql:dbname=employees;host=127.0.0.1', 'root', '');

$dbh->exec("UPDATE click SET num = num + 1 WHERE id = 1");