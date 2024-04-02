<?php
require "Auth2FA.php";

//$secret = Auth2FA::generateSecret();
// OR
$secret = 'OVZ7 JFIP IXE4 RTCE GCQE G2JN UY2Q PVD6'; // Replace your secret code

$totp = Auth2FA::TOTP($secret, 30);
/*
 $totp is array like: ['code'=>111222, 'expire'=>1712003400];
*/
list($otpCode, $expirationTime) = array_values($totp);


echo "Code: $otpCode".PHP_EOL;
echo "Expire on ".date("H:i:s", $expirationTime)." (".($expirationTime - time())."s remind)".PHP_EOL;
