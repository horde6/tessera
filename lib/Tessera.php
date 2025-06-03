<?php
require_once 'tessera/googleauth.php';

class Tessera {
	public static function SiteName() {
		$sitename = $GLOBALS['conf']['general']['name'];
		if (empty($sitename)) {
			$sitename = 'Horde';
		}
		return $sitename;
	}
	
	public static function QRCodeAuth($user, $secret) {
		$url = GoogleAuth::GetUri(self::SiteName(), $user, $secret);
		return self::QRCode($url);
	}
	
	public static function QRCode($url, $size = 3, $type = 'H') {
		require_once 'tessera/barcode.php';
		return BarCode::QRCode($url, $size, $type);
	}
	
	public static function GenerateKey() {
		return GoogleAuth::GenerateKey();
	}

	public static function Authenticate($secret, $otp) {
		return GoogleAuth::Authenticate($secret, $otp);
	}

	public static function GetCode($secret) {
		return GoogleAuth::CurrentCode($secret);
	}
}
