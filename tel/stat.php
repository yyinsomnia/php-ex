<?php
ini_set('memory_limit', '1024M');

$tel_for_test = explode("\n", file_get_contents(__DIR__ . '/phones.txt'));

$internationalPrefixNumDict = require __DIR__ . '/international_prefix_num.php';
$countryCode = require __DIR__ . '/country_code.php';
$agencyCode = require __DIR__ . '/agency_code.php';


require __DIR__ . '/Lexer.php';

$lexer = new Lexer($internationalPrefixNumDict, $countryCode, $agencyCode);

foreach ($tel_for_test as $t) {
    $lexer->handle($t);
    echo $t . "\t" . $lexer->getStdTel() . PHP_EOL;

}