<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 2025-07-11
 * Time: 8:10 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\String;

/**
 * Class CronUtilus
 * @package camilord\utilus\Data
 */
class CronUtilus
{
    /**
     * Validate cron schedule string, sample: 30 * * * 1-5
     * @param string $str
     * @return bool
     */
    public static function isValid(string $str): bool 
    {
        $regex = "/^((?:[1-9]?\d|\*)\s*(?:(?:[\/-][1-9]?\d)|(?:,[1-9]?\d)+)?\s*){5}$/";
        return (preg_match($regex, $str) > 0);
    }
}