<?php

/**
 * 绝对路径(/home/leo/web/php-ex/a.php)             不解释
 * 相对路径(./php-ex/a.php  ../web/php-ex/a.php)    相对路径的基点，永远都是当前工作目录
 * 都不是(a.php php-ex/a.php)                       ".:path_included:current_script_dir" 这里.就是当前工作目录
 *
 * 疑问:
 * 什么时当前工作目录？php-fpm工作时当前工作目录是什么？
 */
require("./sub_dir/two.php");