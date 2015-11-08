<?php
/**
 * User: leo
 * Date: 11/8/15
 * Time: 23:57
 */

function filter_contact($str)
{
    $arr = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
    $len = count($arr);
    $index = 0;

    /* +86, 0086, +0086 */
    $head_5 = '';
    for ($i = 0; $i < 5; $i++) {
        if ($index >= $len) {
            return '';
        }
        while (!is_numeric($arr[$index]) && $arr[$index] !== '+' ) {
            if (++$index >= $len) {
                return '';
            }
        }
        $head_5 .= $arr[$index++];
    }
    if ($head_5 === '+0086') {
        $body_2 = '';
        for ($i = 0; $i < 2; $i++) {
            if ($index >= $len) {
                return '';
            }
            while (!is_numeric($arr[$index])) {
                if (++$index >= $len) {
                    return '';
                }
            }
            $body_2 .= $arr[$index++];
        }
        if ($body_2 === '10') { //beijing
            return filter_tel(array_merge(['0', '1', '0'], array_slice($arr, $index)));
        } elseif (substr($body_2, 0, 1) === '1') { //mobile
            return filter_mobile(array_merge(str_split($body_2), array_slice($arr, $index)));
        } else {
            return '';
        }

    } elseif (substr($head_5, 0, 3) === '+86') {
        $body_2 = substr($head_5, 3, 2);
        if ($body_2 === '10') { //beijing
            return filter_tel(array_merge(['0', '1', '0'], array_slice($arr, $index)));
        } elseif (substr($body_2, 0, 1) === '1') { //mobile
            return filter_mobile(array_merge(str_split($body_2), array_slice($arr, $index)));
        } else {
            return '';
        }
    } elseif (substr($head_5, 0, 4) === '0086') {
        $body_2 = substr($head_5, 4, 1);
        if ($index >= $len) {
            return '';
        }
        while (!is_numeric($arr[$index])) {
            if (++$index >= $len) {
                return '';
            }
        }
        $body_2 .= $arr[$index++];
        if ($body_2 === '10') { //beijing
            return filter_tel(array_merge(['0', '1', '0'], array_slice($arr, $index)));
        } elseif (substr($body_2, 0, 1) === '1') { //mobile
            return filter_mobile(array_merge(str_split($body_2), array_slice($arr, $index)));
        } else {
            return '';
        }
    } elseif (substr($head_5, 0, 1) === '1') { //mobile
        return filter_mobile(array_merge(str_split($head_5), array_slice($arr, $index)));
    } elseif (substr($head_5, 0, 1) === '0') { //tel
        return filter_tel(array_merge(str_split($head_5), array_slice($arr, $index)));
    } elseif (substr($head_5, 0, 3) === '400') {
        return filter_400(array_merge(str_split($head_5), array_slice($arr, $index)));
    } elseif (substr($head_5, 0, 3) === '800') {
        return filter_800(array_merge(str_split($head_5), array_slice($arr, $index)));
    } else {
        return '';
    }

}

function filter_mobile($arr)
{
    $res = '';
    if (($len = count($arr)) === 0) {
        return '';
    }
    $index = 0;
    for ($i = 0; $i < 11; $i++) {
        if ($index >= $len) {
            return '';
        }
        while (!is_numeric($arr[$index])) {
            if (++$index >= $len) {
                return '';
            }
        }
        $res .= $arr[$index++];
    }
    return $res;
}

/**
 * format xxx-xxxxxxxx-xx
 * @param $arr
 * @return string
 */
function filter_tel($arr)
{
    $res = '';
    if (($len = count($arr)) === 0) {
        return '';
    }
    $index = 0;
    while (!is_numeric($arr[$index])) {
        if (++$index >= $len) {
            return '';
        }
    }
    if ($arr[$index++] !== '0') {
        return '';
    }

    /* 1st segment begin */
    $res .= '0';
    if ($index >= $len) {
        return '';
    }
    while (!is_numeric($arr[$index])) {
        if (++$index >= $len) {
            return '';
        }
    }
    if ($arr[$index] === '1' || $arr[$index] === '2') {
        $is_sure_8_num = true;
        $res .= $arr[$index++];
        if ($index >= $len) {
            return '';
        }
        while (!is_numeric($arr[$index])) {
            if (++$index >= $len) {
                return '';
            }
        }
        $res .= $arr[$index++];
    } else {
        $is_sure_8_num = false; // maybe 7 or 8
        $res .= $arr[$index++];
        for ($i = 0; $i < 2; $i++) {
            if ($index >= $len) {
                return '';
            }
            while (!is_numeric($arr[$index])) {
                if (++$index >= $len) {
                    return '';
                }
            }
            $res .= $arr[$index++];
        }
    }
    /* 1st segment finish */

    $res .= '-';

    /* 2nd segment begin */
    for ($i = 0; $i < 7; $i++) {
        if ($index >= $len) {
            return '';
        }
        while (!is_numeric($arr[$index])) {
            if (++$index >= $len) {
                return '';
            }
        }
        $res .= $arr[$index++];
    }

    if ($is_sure_8_num) {
        if ($index >= $len) {
            return '';
        }
        while (!is_numeric($arr[$index])) {
            if (++$index >= $len) {
                return '';
            }
        }
        $res .= $arr[$index++];
    } else { //not sure is 7 or 8
        if ($index >= $len) {
            return $res; // end
        } else {
            if (is_numeric($arr[$index])) {
                $res .= $arr[$index++];
            } else {
                $index++;
            }
        }
    }
    /* 2nd finish */

    $res .= '-';

    /* 3rd begin */
    while ($index < $len) {
        while (!is_numeric($arr[$index])) {
            if (++$index >= $len) {
                return $res;
            }
        }
        $res .= $arr[$index++];
    }
    /* 3rd finish */

    return rtrim($res, '-');

}

function filter_400($arr)
{
    $res = '';
    if (($len = count($arr)) === 0) {
        return '';
    }
    $index = 0;
    for ($i = 0; $i < 10; $i++) {
        if ($index >= $len) {
            return '';
        }
        while (!is_numeric($arr[$index])) {
            if (++$index >= $len) {
                return '';
            }
        }
        $res .= $arr[$index++];
    }
    return $res;
}


function filter_800($arr)
{
    $res = '';
    if (($len = count($arr)) === 0) {
        return '';
    }
    $index = 0;
    for ($i = 0; $i < 10; $i++) {
        if ($index >= $len) {
            return '';
        }
        while (!is_numeric($arr[$index])) {
            if (++$index >= $len) {
                return '';
            }
        }
        $res .= $arr[$index++];
    }
    return $res;
}