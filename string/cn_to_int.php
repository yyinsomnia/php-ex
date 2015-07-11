<?php


/**
 * @param $str
 * 十三亿 一百零八 七十二 三百六 二万五
 */
function cn_to_int($str)
{
    $result = 0;
    $unit = ['亿' => 100000000, '万' => 10000, '千' => 1000, '百' => 100, '十' => 10];
    $num = ['九' => 9, '八' => 8, '七' => 7, '六' => 6, '五' => 5, '四' => 4, '三' => 3, '二' => 2,'两' => 2, '一' => 1, '零' => 0];
    $str_arr = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
    $tmp_int = null;
    $is_right_end = false;
    foreach ($str_arr as $index => $c) {
        if (isset($num[$c])) {
            if ($c === '零') {
                continue;
            } else {
                $tmp_int = $num[$c];
            }
        } elseif ($c === '十' && $index === 0) {
            $tmp_int = 10;
        } elseif (isset($unit[$c])) {
            if ($tmp_int !== null) {
                $result += $tmp_int * $unit[$c];
                $tmp_int = null;
            } elseif ($result > 0) {
                $result *= $unit[$c];
            } else {
                return -1;
            }
        }
    }
    if ($tmp_int !== null) {
        if (isset($unit[$str_arr[$index - 1]])) { //倒数第二个汉子是单位
            $result += $unit[$str_arr[$index - 1]] / 10 * $tmp_int;
        } else {
            $result += $tmp_int;
        }
    }

    return $result;
}

$str = '二万五';
var_dump(cn_to_int($str));