<?php

function rotate_90(array $a) {
    $b = [];
    $rows = count($a);
    $columns = count($a[0]);
    for ($i = 0; $i < $rows; $i++) {
        for ($j = 0; $j < $columns; $j++) {
            $b[$j][$rows - $i - 1] = $a[$i][$j];
        }
    }
    return $b;
}

$a = [
    [1, 3, 2],
    [9, 4, 6],
];

var_export(rotate_90($a));