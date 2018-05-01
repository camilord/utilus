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
 * Class DataCrypt56
 * @package camilord\utilus\Encryption
 */
class DataCrypt56 implements DataCryptInterface
{
    /**
     * @var string
     */
    var $skey 	= "bjC69ZEy2TcYJ4D4ld16T2hE7YcDR7dv";

    /**
     * @param $string
     * @return mixed|string
     */
    public function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    /**
     * @param $string
     * @return bool|string
     */
    public function safe_b64decode($string)
    {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    /**
     * @param $value
     * @return bool|string
     */
    public function encode($value)
    {
        if(!$value){return false;}

        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);

        return trim($this->safe_b64encode($crypttext));
    }

    /**
     * @param $value
     * @return bool|string
     */
    public function decode($value)
    {
        if(!$value){return false;}

        $crypttext = $this->safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);

        return trim($decrypttext);
    }
}