<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 3/26/16
 * Time: 15:16
 */


function p1($f) {
    $f = preg_replace('{^.*/}', '', $f);
    $f = preg_replace('{^.*\\\}', '', $f);
    return $f;
}

function p2($f) {
    $p = '{([^/]*)$)}'; //$1
    // 注意这种写法的效率
}

function p3($f) {
    $p = '{^(.*)/([^/]*)$}';
}
