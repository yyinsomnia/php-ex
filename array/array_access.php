<?php

$a = [1, 3];

function foo(\ArrayAccess $p) {
    return $p;
}


var_dump(foo($a)); //Argument 1 passed to foo() must implement interface ArrayAccess, array given