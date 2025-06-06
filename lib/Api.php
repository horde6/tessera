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

        $uid = $GLOBALS['registry']->convertUsername($uid, TRUE);

        $secret = $driver->getSecret($uid);

        if ($secret == '') {
            if ($this->isOptional()) {
                return TRUE;
            }

            // fallback to a special secret for new users
            $secret = $driver->getSecret('[NEW]');
        }

        if (OtpAuth::Authenticate($secret, $input)) {
            return TRUE;
        }

        // The below probably does not belong here
        // Instead of TRUE/FALSE we could return string with error message
        $auth = $GLOBALS['injector']->getInstance('Horde_Core_Factory_Auth')->create();

        // Note, we intentionally do not disclose if user has not configured OTP
        $auth->setError(Horde_Auth::REASON_MESSAGE, empty($input) ? 'One-time password is not entered.' : 'One-time password is invalid.');

        return FALSE;
    }
}
