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
    public function isOptional(?string $uid = null): bool
    {
        $mode = Tessera::Mode();

        return $mode != 'required';
    }

    public function isEnabled(?string $uid = null): bool
    {
        $mode = Tessera::Mode();
        return $mode != 'disabled';
    }

    public function showCode(): bool
    {
        return Tessera::showCode();
    }

    public function isSetup(string $uid): bool
    {
        $driver = $GLOBALS['injector']->getInstance('Tessera_Driver');
        $uid = $GLOBALS['registry']->convertUsername($uid, true);
        return $driver->getSecret($uid) !== '';
    }

    /**
     * Check if a given input is the currently valid OTP for the user
     *
     * @param string $uid    User ID
     * @param string $input  OTP to check
     * @return string        Error message if OTP is invalid/missing, empty string otherwise
     */
    public function blockLogin(string $uid, string $input): string
    {
        if (!$this->isEnabled()) {
            return '';
        }

        $driver = $GLOBALS['injector']->getInstance('Tessera_Driver');

        $uid = $GLOBALS['registry']->convertUsername($uid, true);

        $secret = $driver->getSecret($uid);

        if ($secret === '') {
            if ($this->isOptional()) {
                return '';
            }

            // fallback to a special secret for new users
            $secret = $driver->getSecret('[NEW]');
        }

        if ($input === '') {
            return  'One-time password is not entered.';
        }

        if (Tessera::Authenticate($secret, $input)) {
            return '';
        }

        // Note, we intentionally do not disclose if user has not configured OTP
        return 'One-time password is invalid or expired.';
    }
}
