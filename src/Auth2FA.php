<?php
namespace imseyed\Auth2FA;

class Auth2FA{
	/**
	 * @param $secret
	 * @param int $timeSlice
	 *
	 * @return string
	 */
	static function TOTP($secret, int $timeSlice=30): string
	{
		$secret = self::base32_decode($secret);
		$timeSliceBasedValue=floor(time()/$timeSlice);
		$data=pack('J', $timeSliceBasedValue);
		$hash=hash_hmac('sha1', $data, $secret, true);
		$offset=ord($hash[19])&0xf;
		$otp   =(
			        ((ord($hash[$offset+0])&0x7f)<<24)|
			        ((ord($hash[$offset+1])&0xff)<<16)|
			        ((ord($hash[$offset+2])&0xff)<<8)|
			        (ord($hash[$offset+3])&0xff)
		        )%1000000;
		return str_pad($otp, 6, '0', STR_PAD_LEFT);
	}
	
	/**
	 * Return expire time of current TOTP code
	 *
	 * @param $secret
	 * @param int $timeSlice
	 *
	 * @return int
	 */
	static function expire_time(int $timeSlice=30): int
	{
		$timeSliceBasedValue=floor(time()/$timeSlice);
		return ($timeSliceBasedValue+1)*$timeSlice;
	}
	
	/**
	 * Generate HMAC-based One Time Password
	 * @param $secret
	 * @param $counter
	 *
	 * @return string OTP code
	 */
	static function HOTP($secret, $counter): string
	{
		$secret = self::base32_decode($secret);
		$counter=pack('N*', 0).pack('N*', $counter);
		$hash   =hash_hmac('sha1', $counter, $secret, true);
		$offset =ord($hash[19])&0xf;
		$code   =(
			         ((ord($hash[$offset+0])&0x7f)<<24)|
			         ((ord($hash[$offset+1])&0xff)<<16)|
			         ((ord($hash[$offset+2])&0xff)<<8)|
			         (ord($hash[$offset+3])&0xff)
		         )%1000000;
		
		return str_pad($code, 6, '0', STR_PAD_LEFT);
	}
	
	/**
	 * Generate random secret key
	 *
	 * @param int $length
	 *
	 * @return string secret key
	 */
	public static function generate_secret(int $length = 32): string
	{
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
		$secret = '';
		$maxIndex = strlen($characters) - 1;
		for ($i=0; $i<$length; $i++) {
			$secret .= $characters[rand(0, $maxIndex)];
		}
		return $secret;
	}
	
	/**
	 * Decode a base32-encoded string.
	 *
	 * @param string $str The base32-encoded string to decode.
	 *
	 * @return string Returns the decoded string.
	 */
	static function base32_decode(string $str): string
	{
		$str = strtoupper($str);
		$str       =str_replace(' ', '', $str);
		$str       =str_replace('-', '', $str);
		$chars     ='ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
		$map       =array_flip(str_split($chars));
		$data      ='';
		$len       =strlen($str);
		$buffer    =0;
		$bufferSize=0;
		for($i=0; $i<$len; $i ++){
			$char      =strtoupper($str[$i]);
			$byte      =$map[$char];
			$buffer    =($buffer<<5)|$byte;
			$bufferSize+=5;
			if($bufferSize>=8){
				$bufferSize-=8;
				$data .= chr(($buffer>>$bufferSize)&0xFF);
			}
		}
		return $data;
	}
}