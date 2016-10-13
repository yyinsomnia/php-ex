<?php
ini_set('memory_limit', '1024M');

$tel_for_test = explode("\n", file_get_contents(__DIR__ . '/caller_sample.txt'));
//$tel_for_test = array('95533', );


$internationalPrefixNumDict = require __DIR__ . '/international_prefix_num.php';
$countryCode = require __DIR__ . '/country_code.php';
$agencyCode = require __DIR__ . '/agency_code.php';
$spCode = require __DIR__ . '/sp_code.php';

require __DIR__ . '/Lexer.php';

$lexer = new Lexer($internationalPrefixNumDict, $countryCode, $agencyCode, $spCode);

$len_dict = array();

foreach ($tel_for_test as $t) {
    if ($lexer->handle($t)) {
        echo $t . "\t" . $lexer->getStdTel() . "\t" . PHP_EOL;
    } else {
        //echo $t . "\t" . $lexer->getStdTel() . "\t" . PHP_EOL;
    }
}

//print_r($len_dict);
