<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 3/26/16
 * Time: 15:58
 */

function p1() {
    $p = '{\bfoo\([^)]*\}';
}

function p2() {
    $p = '{\([^()]*\)}'; //只能匹配一层
}

function p3() {
    $p = '%\([^()]*(\([^()]*\)[^()]*)*\)%'; //2层
}

function p4() {
    $p = '%\([^()]*(\([^()]*(\([^()]*\)[^()]*)*\)[^()]*)*\)%'; //3层
}

function p5() {
    $p = '%"([^"]|(?<=\\)")*"%'; //匹配引号之间，考虑转义
    //考虑"/-|-\\"
}

function p6() {
    $p = '%"(\\.|[^"\\])"%';
}


