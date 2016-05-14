<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 3/26/16
 * Time: 17:04
 */

function p1() {
    $p = '%<[^>]+>%';
}

function p2() {
    $p = <<<'EOT'
%<("[^"]*"|'[^']*'|[^"'>])*>%
EOT;

}



