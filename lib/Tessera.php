<?php

declare(strict_types=1);

use Horde\Otp\ProvisioningUri;
use Horde\Otp\Secret;
use Horde\Otp\Totp;
use Horde\Otp\TotpParameters;

class Tessera
{
    public static function SiteName(): string
    {
        $sitename = $GLOBALS['conf']['general']['name'] ?? '';
        if (empty($sitename)) {
            $sitename = 'Horde';
        }
        return $sitename;
    }

    public static function Mode(): string
    {
        return $GLOBALS['conf']['general']['mode'] ?? 'disabled';
    }

    public static function showCode(): bool
    {
        return $GLOBALS['conf']['general']['showcode'] ?? true;
    }

    public static function QRCodeAuth(string $user, string $secret): string
    {
        $uri = new ProvisioningUri(
            Secret::fromBase32($secret),
            $user,
            self::SiteName(),
            new TotpParameters(),
        );
        return self::QRCode((string) $uri);
    }

    public static function QRCode(string $url, int $size = 3, string $type = 'H'): string
    {
        $qrcode = new TCPDF2DBarcode($url, 'QRCODE,' . $type);
        return $qrcode->getBarcodeHTML($size, $size);
    }

    public static function GenerateKey(): string
    {
        return Secret::generate(20)->toBase32();
    }

    public static function Authenticate(string $secret, string $otp): bool
    {
        $totp = new Totp(new TotpParameters());
        return $totp->verify(Secret::fromBase32($secret), $otp, time()) !== null;
    }

    public static function GetCode(string $secret): string
    {
        $totp = new Totp(new TotpParameters());
        return $totp->generate(Secret::fromBase32($secret), time())->code;
    }
}
