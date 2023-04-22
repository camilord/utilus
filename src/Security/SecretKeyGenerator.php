<?php

namespace camilord\utilus\Security;

use camilord\utilus\Algorithm\UUID;

/**
 * use for generating Authorization key or random string
 */
class SecretKeyGenerator
{
    /**
     * @return string
     */
    public static function generate(): string
    {
        $privateKey = openssl_pkey_new(array('private_key_bits' => 2048));
        $details = openssl_pkey_get_details($privateKey);
        $publicKey = ($details['key'] ?? self::alt_api_secret_key());

        $publicKey = self::clean($publicKey);

        if (!$publicKey) {
            $publicKey = self::alt_api_secret_key();
        }

        return $publicKey;
    }

    /**
     * @return string
     */
    public static function alt_api_secret_key(): string
    {
        return UUID::getRandomUUID().'.'.
            sha1(time()).'.'.
            md5(time()).'.'.
            UUID::v4();
    }

    public static function clean(string $publicKey): string
    {
        $publicKey = str_replace("\n", '', $publicKey);
        $publicKey = str_replace("-----BEGIN PUBLIC KEY-----", '', $publicKey);
        $publicKey = str_replace("-----END PUBLIC KEY-----", '', $publicKey);

        return trim($publicKey);
    }
}