<?php

$tel_for_test = array(
    '+0196852202',
    '+0190852213',
    '+10658186',
    '+8610085139',
    '+8610658283',
    '+000190852213',
    '+862010086',
    '+862195512',
    '+0196852202',
);


$internationalPrefixNumDict = require __DIR__ . '/international_prefix_num.php';
$countryCode = require __DIR__ . '/country_code.php';
$agencyCode = require __DIR__ . '/agency_code.php';


require __DIR__ . '/Lexer.php';

$lexer = new Lexer($internationalPrefixNumDict, $countryCode, $agencyCode);

foreach ($tel_for_test as $t) {
    $lexer->handle($t);
    echo $t . "\t" . $lexer->getStdTel() . PHP_EOL;

}
