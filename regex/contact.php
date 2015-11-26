<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 15-11-9
 * Time: 上午11:42
 */

class LeoContactFilter
{
    const EMPTY_TYPE = 0;
    const TEL_TYPE = 1;
    const MOBILE_TYPE = 2;
    const FOUR00_TYPE = 3;
    const EIGHT00_TYPE =4;

    public static function filterContactMobile($str)
    {
        $arr = self::filterContact($str);
        if ($arr[1] === self::MOBILE_TYPE) {
            return $arr[0];
        } else {
            return '';
        }
    }

    public static function filterContactTel($str)
    {
        $arr = self::filterContact($str);
        if ($arr[1] === self::TEL_TYPE) {
            return $arr[0];
        } else {
            return '';
        }
    }

    public static function filterContact400($str)
    {
        $arr = self::filterContact($str);
        if ($arr[1] === self::FOUR00_TYPE) {
            return $arr[0];
        } else {
            return '';
        }
    }

    public static function filterContact800($str)
    {
        $arr = self::filterContact($str);
        if ($arr[1] === self::EIGHT00_TYPE) {
            return $arr[0];
        } else {
            return '';
        }
    }

    public static function filterContact($str)
    {
        $arr = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
        $len = count($arr);
        $index = 0;
        $empty_return_arr = ['', self::EMPTY_TYPE];

        /* +86, 0086, +0086 */
        $head_5 = '';
        for ($i = 0; $i < 5; $i++) {
            if ($index >= $len) {
                return $empty_return_arr;
            }
            while (!is_numeric($arr[$index]) && $arr[$index] !== '+' ) {
                if (++$index >= $len) {
                    return $empty_return_arr;
                }
            }
            $head_5 .= $arr[$index++];
        }
        if ($head_5 === '+0086') {
            $body_2 = '';
            for ($i = 0; $i < 2; $i++) {
                if ($index >= $len) {
                    return $empty_return_arr;
                }
                while (!is_numeric($arr[$index])) {
                    if (++$index >= $len) {
                        return $empty_return_arr;
                    }
                }
                $body_2 .= $arr[$index++];
            }
            if ($body_2 === '10') { //beijing tel
                $return_str = self::filterTel(array_merge(['0', '1', '0'], array_slice($arr, $index)));
                if ($return_str === '') {
                    return $empty_return_arr;
                } else {
                    return [$return_str, self::TEL_TYPE];
                }
            } elseif (substr($body_2, 0, 1) === '1') { //mobile
                $return_str = self::filterMobile(array_merge(str_split($body_2), array_slice($arr, $index)));
                if ($return_str === '') {
                    return $empty_return_arr;
                } else {
                    return [$return_str, self::MOBILE_TYPE];
                }
            } else { //tel
                $return_str = self::filterTel(array_merge(['0'], str_split($body_2), array_slice($arr, $index)));
                if ($return_str === '') {
                    return $empty_return_arr;
                } else {
                    return [$return_str, self::TEL_TYPE];
                }
            }

        } elseif (substr($head_5, 0, 3) === '+86') {
            $body_2 = substr($head_5, 3, 2);
            if ($body_2 === '10') { //beijing tel
                $return_str = self::filterTel(array_merge(['0', '1', '0'], array_slice($arr, $index)));
                if ($return_str === '') {
                    return $empty_return_arr;
                } else {
                    return [$return_str, self::TEL_TYPE];
                }
            } elseif (substr($body_2, 0, 1) === '1') { //mobile
                $return_str = self::filterMobile(array_merge(str_split($body_2), array_slice($arr, $index)));
                if ($return_str === '') {
                    return $empty_return_arr;
                } else {
                    return [$return_str, self::MOBILE_TYPE];
                }
            } else { //tel
                $return_str = self::filterTel(array_merge(['0'], str_split($body_2), array_slice($arr, $index)));
                if ($return_str === '') {
                    return $empty_return_arr;
                } else {
                    return [$return_str, self::TEL_TYPE];
                }
            }
        } elseif (substr($head_5, 0, 4) === '0086') {
            $body_2 = substr($head_5, 4, 1);
            if ($index >= $len) {
                return $empty_return_arr;
            }
            while (!is_numeric($arr[$index])) {
                if (++$index >= $len) {
                    return $empty_return_arr;
                }
            }
            $body_2 .= $arr[$index++];
            if ($body_2 === '10') { //beijing tel
                $return_str =  self::filterTel(array_merge(['0', '1', '0'], array_slice($arr, $index)));
                if ($return_str === '') {
                    return $empty_return_arr;
                } else {
                    return [$return_str, self::TEL_TYPE];
                }
            } elseif (substr($body_2, 0, 1) === '1') { //mobile
                $return_str = self::filterMobile(array_merge(str_split($body_2), array_slice($arr, $index)));
                if ($return_str === '') {
                    return $empty_return_arr;
                } else {
                    return [$return_str, self::MOBILE_TYPE];
                }
            } else { //tel
                $return_str = self::filterTel(array_merge(['0'], str_split($body_2), array_slice($arr, $index)));
                if ($return_str === '') {
                    return $empty_return_arr;
                } else {
                    return [$return_str, self::TEL_TYPE];
                }
            }
        } elseif (substr($head_5, 0, 1) === '1') { //mobile
            $return_str = self::filterMobile(array_merge(str_split($head_5), array_slice($arr, $index)));
            if ($return_str === '') {
                return $empty_return_arr;
            } else {
                return [$return_str, self::MOBILE_TYPE];
            }
        } elseif (substr($head_5, 0, 1) === '0') { //tel
            $return_str = self::filterTel(array_merge(str_split($head_5), array_slice($arr, $index)));
            if ($return_str === '') {
                return $empty_return_arr;
            } else {
                return [$return_str, self::TEL_TYPE];
            }
        } elseif (substr($head_5, 0, 3) === '400') {
            $return_str = self::filter400(array_merge(str_split($head_5), array_slice($arr, $index)));
            if ($return_str === '') {
                return $empty_return_arr;
            } else {
                return [$return_str, self::FOUR00_TYPE];
            }
        } elseif (substr($head_5, 0, 3) === '800') {
            $return_str = self::filter800(array_merge(str_split($head_5), array_slice($arr, $index)));
            if ($return_str === '') {
                return $empty_return_arr;
            } else {
                return [$return_str, self::EIGHT00_TYPE];
            }
        } else {
            return $empty_return_arr;
        }

    }

    protected static function filterMobile($arr)
    {
        if (is_string($arr)) {
            $arr = preg_split('//u', $arr, -1, PREG_SPLIT_NO_EMPTY);
        }
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
    protected static function filterTel($arr)
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
                while (strpos(" \t\n\r\0\x0B", $arr[$index]) !== false) { //left trim
                    if (++$index >= $len) {
                        return '';
                    }
                }
                if (is_numeric($arr[$index])) {
                    $res .= $arr[$index++];
                } else {
                    $index++;
                }
            }
        }
        /* 2nd finish */

        $one_plus_two_length = strlen($res);

        $res .= '-';

        /* 3rd begin */
        $third_len = 0;
        while ($index < $len) {
            while (!is_numeric($arr[$index])) {
                if (++$index >= $len) {
                    if ($third_len > 5) {
                        return substr($res, 0, $one_plus_two_length);
                    } else {
                        return rtrim($res, '-');
                    }
                }
            }
            $res .= $arr[$index++];
            $third_len++;
        }
        /* 3rd finish */

        if ($third_len > 5) {
            return substr($res, 0, $one_plus_two_length);
        } else {
            return rtrim($res, '-');
        }

    }

    protected static function filter400($arr)
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


    protected static function filter800($arr)
    {
        if (is_string($arr)) {
            $arr = preg_split('//u', $arr, -1, PREG_SPLIT_NO_EMPTY);
        }
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
}