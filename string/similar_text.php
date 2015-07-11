<?php

$str1 = '我们都是中国人';
$str2 = '我们都爱我们的祖国';

var_dump(similar_text($str1, $str2)); // int(14)
var_dump(strlen("我们都国")); // int(12)
/**
 * 这里存在一个问题：
 * 计算用的是以字节位单位，而不是以mb字符
 * 刚开始我以为只要如果是算差一个汉字(utf-8)
 * 用min($str1, str2) - similar_text($str1, $str2) <= 4
 * 这里是有问题的，similar_text算出来的会比用LCS针对每个utf-8字符算出来(再转换为字节)的要大(或等)
 * 所以这种算法并不准确,就譬如上面的例子。
 */