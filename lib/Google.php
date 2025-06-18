<?php

class Tessera_Google
{
    // Base32 encoding characters
    protected static $Base32Chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";

    // According to the spec, this could be something other than 6. But again, apparently Google Authenticator ignores that part of the spec...
    protected static $CodeLength = 6;

    public static function Authenticate($secret, $code, $window = 1)
    {
        $length = strlen($secret);
        if ($length == 0 || $length % 8 > 0) {
            return false; // wrong secret
        }

        $time = floor(time() / 30);

        for ($i = -$window; $i <= $window; ++$i) {
            $scode = self::CalculateCode($secret, $time + $i);
            if ($scode == $code) {
                return true;
            }
        }

        return false;
    }

    public static function CurrentCode($secret)
    {
        $length = strlen($secret);
        if ($length == 0 || $length % 8 > 0) {
            return false; // wrong secret
        }

        $time = floor(time() / 30);
        return self::CalculateCode($secret, $time);
    }

    private static function CalculateCode($secret, $time)
    {
        // Packs the timeslice as a "unsigned long" (always 32 bit, big endian byte order)
        $time = pack("N", $time);

        // Then pad it with the null terminator
        $time = str_pad($time, 8, chr(0), STR_PAD_LEFT);

        // Hash it with SHA1. The spec does offer the idea of other algorithms, but notes that the authenticator is currently ignoring it...
        $hash = hash_hmac("SHA1", $time, self::DecodeKey($secret), true);

        // Last 4 bits are an offset apparently
        $offset = ord(substr($hash, -1)) & 0x0F;

        // Grab the last 4 bytes
        $result = substr($hash, $offset, 4);

        // Unpack it again
        $value = unpack('N', $result)[1];

        // Only 31 bits
        $value = $value & 0x7FFFFFFF;

        // Modulo down to the right number of digits
        $modulo = pow(10, self::$CodeLength);

        // Finally, pad out the string with 0s
        return str_pad($value % $modulo, self::$CodeLength, '0', STR_PAD_LEFT);
    }

    public static function GenerateKey($length = 32)
    {
        $key = "";
        for ($i = 0; $i < $length; ++$i) {
            $key .= self::$Base32Chars[random_int(0, 31)];
        }

        return $key;
    }

    public static function DecodeKey($key)
    {
        if (!is_string($key)) {
            return false;
        }

        $length = strlen($key);
        if ($length == 0 || $length % 8 > 0) {
            return false;
        }

        // The last encoded character is $key[$lastIndex]
        $lastIndex = $length - 1;

        $chars = self::$Base32Chars;
        $bitsPerCharacter = 5;

        $rawString = '';
        $byte = 0;
        $bitsWritten = 0;

        // Convert each encoded character to a series of unencoded bits
        for ($c = 0; $c <= $lastIndex; ++$c) {
            $index = strpos($chars, $key[$c]);
            if ($index === false) {
                return false;
            }

            // Get the new bits ready
            $bitsWritten += $bitsPerCharacter;
            if ($bitsWritten >= 8) {
                // Zero or more too many bits to complete a byte; shift right
                $bitsWritten -= 8;
                $newBits = $index >> $bitsWritten;
                $byte |= $newBits;

                // Byte is ready to be written
                $rawString .= pack('C', $byte);

                if ($c != $lastIndex) {
                    $byte = ($index ^ ($newBits << $bitsWritten)) << 8 - $bitsWritten;
                }
            } else {
                // New bits aren't enough to complete a byte; shift them left into position
                $newBits = $index << 8 - $bitsWritten;
                $byte |= $newBits;
            }
        }

        return $rawString;
    }

    public static function GetUri($issuer, $accountName, $secretKey)
    {
        // As per spec sheet
        if (strpos($issuer . $accountName, ":") !== false) {
            throw new \InvalidArgumentException("Neither the 'Issuer' parameter nor the 'AccountName' parameter may contain a colon");
        }

        $label = $issuer . ":" . $accountName;

        return "otpauth://totp/" . rawurlencode($label) . "?secret=" . $secretKey . "&issuer=" . rawurlencode($issuer);
    }
}
