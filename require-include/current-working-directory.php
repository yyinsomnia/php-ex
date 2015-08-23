<?php


echo getcwd();
echo PHP_EOL;
// get /home/leo/web/github/php-ex/require-include from web
// get /home/leo from cli when pwd is /home/leo

require './s/cwd.php';

// in ./s/cwd.php get /home/leo/web/github/php-ex/require-include from web
// in require failed to open stream from cli when pwd is /home/leo