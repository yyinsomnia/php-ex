<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 9/22/15
 * Time: 00:59
 */

$handle_source = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'word.txt', 'r');
$handle_destination = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'word_filter.txt', 'a');

while (($line = fgets($handle_source)) !== false ) {
    $words = explode(',', $line);
    preg_match('#[\x{4e00}-\x{9fa5}0-9a-zA-Z]+#u', $words[0], $matches);

    $line_filter = $matches[0] . ',' . intval($words[1]) . "\r\n";

    if (strlen($line_filter) > 10) {
        continue;
    }
    fwrite($handle_destination, $line_filter);
}
