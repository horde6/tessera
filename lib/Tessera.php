<?php

class Tessera
{
    public static function SiteName()
    {
        $sitename = $GLOBALS['conf']['general']['name'];
        if (empty($sitename)) {
            $sitename = 'Horde';
        }
        return $sitename;
    }

    public static function Mode()
    {
        return $GLOBALS['conf']['general']['mode'] ?? 'disabled';
    }

    public static function showCode(): bool
    {
        return $GLOBALS['conf']['general']['showcode'] ?? true;
    }

    public static function QRCodeAuth($user, $secret)
    {
        $url = Tessera_Google::GetUri(self::SiteName(), $user, $secret);
        return self::QRCode($url);
    }

    public static function QRCode($url, $size = 3, $type = 'H')
    {
        $qrcode = new TCPDF2DBarcode($url, 'QRCODE,' . $type);
        return $qrcode->getBarcodeHTML($size, $size);
    }

    public static function GenerateKey()
    {
        return Tessera_Google::GenerateKey();
    }

    public static function Authenticate($secret, $otp)
    {
        return Tessera_Google::Authenticate($secret, $otp);
    }

    public static function GetCode($secret)
    {
        return Tessera_Google::CurrentCode($secret);
    }
}
