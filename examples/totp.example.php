<?php
use imseyed\Auth2FA\Auth2FA;
require_once __DIR__ . '/vendor/autoload.php';

//$secret = Auth2FA::generate_secret();
// OR
$secret = 'OVZ7 JFIP IXE4 RTCE GCQE G2JN UY2Q PVD6'; // Replace your secret code

$totp = Auth2FA::TOTP($secret, 30);
$expirationTime = Auth2FA::expire_time(30);


echo "Code: $totp".PHP_EOL;
echo "Expire on ".date("H:i:s", $expirationTime)." (".($expirationTime - time())."s remind)".PHP_EOL;
