<?php
require "Auth2FA.php";

//$secret = Auth2FA::generateSecret();
// OR
$secret = 'OVZ7 JFIP IXE4 RTCE GCQE G2JN UY2Q PVD6'; // Replace your secret code

$hotp = Auth2FA::HOTP($secret, 1);


echo "Code: $hotp".PHP_EOL;