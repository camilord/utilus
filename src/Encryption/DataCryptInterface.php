<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 2/05/2018
 * Time: 12:01 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Encryption;


interface DataCryptInterface
{
    /**
     * @param string $value
     * @return string
     */
    public function encode($value);

    /**
     * @param string $value
     * @return string
     */
    public function decode($value);
}