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

namespace camilord\utilus\Data;

/**
 * Class JsonUtilus
 * @package camilord\utilus\Data
 */
class JsonUtilus
{
    public static function isJson($string): bool 
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}