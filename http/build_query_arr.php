<?php

$query = [
    'series' => '23',
    'tag' => ['good', 'zan']
];

$query_str = http_build_query($query);

echo $query_str;
