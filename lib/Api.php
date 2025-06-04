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
        // TODO
        return true;
    }
    public function isEnabled(): bool
    {
        // TODO
        return true;
    }
    public function userHasConfiguredTwoFactor(string $uid): bool
    {
        // TODO
        return true;
    }
    /**
     * Check if a given input is the currently valid TOTP for this user
     */
    public function checkInput(string $uid, string $input): bool
    {
        // TODO
        return true;
    }
}
