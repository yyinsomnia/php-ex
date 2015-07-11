<?php

$host = 'localhost';
$user = 'root';
$pwd = '';
$db = 'employees';

$result = ['Morton' => 0, 'Rosen' => 0, 'Rissland' => 0];

$time_start = microtime(true);
$links = new SplObjectStorage();

foreach ($result as $key => $value) {
    $obj = new mysqli($host, $user, $pwd, $db);
    $links[$obj] = ['value' => $key, 'link' => $obj];
}

$done = 0;
$total = count($links);
foreach ($links as $value) { //$key is NOT an object, $value is!
    $links[$value]['link']->query("SELECT COUNT(*) AS total FROM employees WHERE last_name = '{$links[$value]['value']}'", MYSQLI_ASYNC);
}

do {
    $tmp = [];
    foreach ($links as $value) {
        $tmp[] = $links[$value]['link'];
    }

    $read = $error = $reject = $tmp;
    $re = mysqli_poll($read, $error, $reject, 1);
    if (false === $re) {
        exit('mysqli_poll failed');
    } elseif ($re < 1) {
        continue;
    }

    foreach ($read as $link) {
        $sql_result = $link->reap_async_query();
        if (is_object($sql_result)) {
            $sql_result_array = $sql_result->fetch_array(MYSQLI_ASSOC);
            $sql_result->free();
            $key_in_result = $links[$link]['value'];
            $result[$key_in_result] = $sql_result_array['total'];
        } else {
            echo $link->error, "\n";
        }
        $done++;
    }

    foreach ($error as $link) {
        echo $link->error, "1\n";
        $done++;
    }

    foreach ($reject as $link) {
        printf("server is busy, client was rejected.\n", $link->connect_error, $link->error);
        //这个地方别再$done++了。
    }
} while ($done < $total);

var_dump($result);
echo "ASYNC_QUERY_TIME:", microtime(true)-$time_start, "\n";

$link = end($links);
$link = $link['link'];
echo "\n";
exit();
//平常顺序执行的时间

$time_start = microtime(true);
$result = ['Morton' => 0, 'Rosen' => 0, 'Rissland' => 0];
$link = new mysqli($host, $user, $pwd, $db);
foreach ($result as $key=>$value) {
    $sql_result = $link->query("SELECT COUNT(*) AS total FROM employees WHERE last_name = '{$key}'");
    if (is_object($sql_result)) {
        $sql_result_array = $sql_result->fetch_array(MYSQLI_ASSOC);
        $sql_result->free();
        $result[$key] = $sql_result_array['total'];
    } else {
        echo "error.\n";
    }
}
var_dump($result);
echo "COMMON_QUERY_TIME:", microtime(true)-$time_start, "\n";
