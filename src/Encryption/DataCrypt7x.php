<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 2/05/2018
 * Time: 12:02 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Encryption;

/**
 * Class DataCrypt7x
 * @package camilord\utilus\Encryption
 */
class DataCrypt7x implements DataCryptInterface
{
    var $secret_key = "bjC69ZEy2TcYJ4D4ld16T2hE7YcDR7dv";
    var $iv_key = "KxsBKHNbqnovPjZA";

    /**
     * @param $string
     * @return string
     */
    public function encode($string)
    {
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $this->secret_key );
        $iv = substr( hash( 'sha256', $this->iv_key ), 0, 16 );

        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );

        return $output;
    }

    /**
     * @param $string
     * @return bool|string
     */
    public function decode($string)
    {
        if (!$string) {
            return false;
        }

        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $this->secret_key );
        $iv = substr( hash( 'sha256', $this->iv_key ), 0, 16 );

        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );

        return $output;
    }
}