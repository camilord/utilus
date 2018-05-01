<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 2/05/2018
 * Time: 12:00 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Encryption;


class DataCrypt implements DataCryptInterface
{
    /**
     * @var DataCryptInterface
     */
    private $crypt;

    /**
     * Crypt constructor.
     */
    public function __construct()
    {
        $phpVersion = null;
        if (defined('PHP_MAJOR_VERSION')) {
            $phpVersion = PHP_MAJOR_VERSION;
        } else {
            $version = explode('.', PHP_VERSION);
            $phpVersion = $version[0].'.'.$version[1];
        }

        if ($phpVersion >= 7) {
            $this->crypt = new DataCrypt7x();
        } else {
            $this->crypt = new DataCrypt56();
        }
    }

    /**
     * @param string $str
     * @return bool|string
     */
    public function encode($str)
    {
        return $this->crypt->encode($str);
    }

    /**
     * @param string $str
     * @return bool|string
     */
    public function decode($str)
    {
        return $this->crypt->decode($str);
    }
}