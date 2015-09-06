<?php

preg_match_all("#[\x{4e00}-\x{9fa5}a-zA-Z0-9\-\.]#u", "21世纪中国基-金..会", $match);

var_dump($match);