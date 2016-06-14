<?php

function sort_insert($array) {
    $count = count($array);
    for ($i = 1; $i < $count; $i++) {
        $tmp = $array[$i];
        for ($j = $i; $j > 0 && $array[$j - 1] > $tmp; $j--) {
            $array[$j] = $array[$j - 1];
        }
        $array[$j] = $tmp;
    }
    return $array;
}

$a = [2, 5, 4, 1, 90, 78];
print_r(sort_insert($a));