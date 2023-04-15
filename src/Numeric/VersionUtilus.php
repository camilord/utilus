<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 6:14 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Numeric;


use camilord\utilus\Data\ArrayUtilus;

/**
 * Class VersionUtilus
 * @package camilord\utilus\Numeric
 */
class VersionUtilus
{
    /**
     * @param string $version
     * @return string
     */
    public static function increment($version) {
        $tmp = explode('.', $version);

        $minor_revision = (int)($tmp[2] ?? '');
        $major_revision = (int)($tmp[1] ?? '');
        $version = (int)$tmp[0];

        $minor_revision++;
        if ($minor_revision > 999) {
            $minor_revision = 0;
            $major_revision++;
        }
        if ($major_revision > 99) {
            $major_revision = 0;
            $version++;
        }
        return $version.'.'.$major_revision.'.'.$minor_revision;
    }
}