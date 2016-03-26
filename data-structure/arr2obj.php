<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 1/30/16
 * Time: 23:59
 */

$a = [
    'title' => 'love',
    'author' => 'leo',
    'comments' => [
        [
            'user' => 'jobs',
            'data' => 'f**k',
        ],
        [
            'user' => 'bill',
            'data' => 'yes',
        ],
    ]
];

$c = (object) $a; //it is not multi dimensions
$b = json_decode(json_encode($a));

var_dump($b->comments[0]->user);