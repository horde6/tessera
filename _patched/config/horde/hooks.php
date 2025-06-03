<?php

class Horde_Hooks
{
    public function preauthenticate($userId, $credentials)
    {
	if (array_key_exists('otp', $credentials)) {
		$user = $this->authusername($userId, TRUE);
		
		// find if OTP is enabled, retrieve secret
		
		$app = 'otpauth';
		$lib_path = realpath(HORDE_BASE . '/../' . $app . '/lib');
		
		require_once $lib_path . '/Application.php');
		
		Horde_Registry::appInit($app);
		
		// important
		$GLOBALS['registry']->importConfig($app);
		
		$otpauth = $GLOBALS['injector']->getInstance('OtpAuth_Driver');
		$secret = $otpauth->getSecret($user);
		
		// fallback to a special secret for new users
		if ($secret == '')
			$secret = $otpauth->getSecret('[NEW]');
		
		// check secret
		$otp = $credentials['otp'] ?? '';
		
		require_once $lib_path . '/otpauth/googleauth.php';
		
		if (!GoogleAuth::Authenticate($secret, $otp)) {
			$auth = $GLOBALS['injector']->getInstance('Horde_Core_Factory_Auth')->create();
			$auth->setError(Horde_Auth::REASON_MESSAGE, $otp == '' ? 'One-time password is not entered.' : 'One-time password is invalid.');
			return FALSE;
		}
	}
	
	return TRUE;
    }
}
