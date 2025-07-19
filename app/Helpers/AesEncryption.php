<?php
// app/Helpers/AesEncryption.php

namespace App\Helpers;

class AesEncryption
{
    public static function hexToBytes($hex)
    {
        return hex2bin($hex);
    }

    public static function bytesToHex($bytes)
    {
        return bin2hex($bytes);
    }

    public static function encrypt($data)
    {
        $key = self::hexToBytes(env('NIFI_ENCRYPTION_KEY'));
        $iv = self::hexToBytes(env('NIFI_ENCRYPTION_IV'));
        $cipher = "AES-256-CBC";

        $json = json_encode($data);
        $encrypted = openssl_encrypt($json, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        return self::bytesToHex($encrypted);
    }

    public static function decrypt($encryptedHex)
    {
        $key = self::hexToBytes(env('NIFI_ENCRYPTION_KEY'));
        $iv = self::hexToBytes(env('NIFI_ENCRYPTION_IV'));
        $cipher = "AES-256-CBC";

        $encryptedBytes = self::hexToBytes($encryptedHex);
        $decrypted = openssl_decrypt($encryptedBytes, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        return json_decode($decrypted, true);
    }
}
