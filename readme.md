
# Two-Factor Authentication (2FA) Library

This PHP library provides functionality for generating Time-based One Time Passwords (TOTP) and HMAC-based One Time Passwords (HOTP), commonly used in two-factor authentication (2FA) systems.

## Features

- **TOTP Generation**: Generate Time-based One Time Passwords.
- **HOTP Generation**: Generate HMAC-based One Time Passwords.
- **Random Secret Key Generation**: Generate random secret keys for use in TOTP and HOTP generation.

## Usage

### TOTP Generation

The `Auth2FA::TOTP` method generates a **Time-based One Time Password** using the provided secret key and optional time slice.
[totp.example.php](totp.example.php)
```php
$totp = Auth2FA::TOTP($secret, $timeSlice);
/*
 $totp is array like: ['code'=>111222, 'expire'=>1712003400];
*/
```

### HOTP Generation

The `Auth2FA::HOTP` method generates an **HMAC-based One Time Password** using the provided secret key and counter value.
[hotp.example.php](hotp.example.php)
```php
$code = Auth2FA::HOTP($secret, $counter);
/*
 $code is string like: 111222
*/
```

### Secret Key Generation

The `Auth2FA::generateSecret` method generates a **random secret key** of the specified length.

```php
$length = 16; // Secret key lenght
$secret = Auth2FA::generateSecret($length);
/*
 $secret is string like: OVZ7JFIPIXE4RTCE
*/
```


Note: There is no separate function to check the correctness of 2fa codes. You must use the generation functions to confirm the correctness of the codes sent by users.

---
## License

This library is released under the [MIT License](LICENSE).