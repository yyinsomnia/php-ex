<?php
ini_set('memory_limit', '1024M');

$tel_for_test = explode("\n", file_get_contents(__DIR__ . '/pianzi_phones.txt'));
//$tel_for_test = array('01013911710090', );

$internationalPrefixNumDict = require __DIR__ . '/international_prefix_num.php';
$countryCode = require __DIR__ . '/country_code.php';
$agencyCode = require __DIR__ . '/agency_code.php';
$spCode = require __DIR__ . '/sp_code.php';

require __DIR__ . '/Lexer.php';

$lexer = new Lexer($internationalPrefixNumDict, $countryCode, $agencyCode, $spCode);

$len_dict = array();

foreach ($tel_for_test as $t) {
    $lexer->setOriginTel($t);
    $lexer->achieveNum();
    $len_dict[$lexer->numTelLen]++;
    //usleep(100000);
}
ksort($len_dict);
print_r($len_dict);