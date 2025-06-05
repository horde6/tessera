<?php
/**
 * Tessera external API.
 *
 * This file defines Tessera's external API interface. Other applications can
 * interact with Tessera through this API.
 *
 * @author    Dmitry Petrov <dpetrov67@gmail.com>
 * @package   Tessera
 */
class Tessera_Api extends Horde_Registry_Api
{
    public function isOptional(): bool
    {
        $mode = OtpAuth::Mode();

        return $mode != 'require';
    }

    public function isEnabled(): bool
    {
        $mode = OtpAuth::Mode();

        return $mode != 'disabled';
    }

    /**
     * Check if a given input is the currently valid TOTP for this user
     */
    public function checkInput(string $uid, string $input): bool
    {
        if (!$this->isEnabled()) {
            return TRUE;
        }

        $driver = $GLOBALS['injector']->getInstance('OtpAuth_Driver');
        $secret = $driver->getSecret($uid);

        // fallback to special secret for new users
        if ($secret == '')
            $secret = $driver->getSecret('[NEW]');

        if ($secret == '' && $this->isOptional()) {
            return TRUE;
        }

        if (OtpAuth::Authenticate($secret, $input)) {
            return TRUE;
        }

        $auth = $GLOBALS['injector']->getInstance('Horde_Core_Factory_Auth')->create();

        // do not disclose if user has not configured OTP
        $auth->setError(Horde_Auth::REASON_MESSAGE, empty($input) ? 'One-time password is not entered.' : 'One-time password is invalid.');

        return FALSE;
    }
}
