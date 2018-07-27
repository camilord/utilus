<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 27/07/2018
 * Time: 7:50 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\IO;


class DirectoryUtil
{
    public static function upLevel($path, $level = 1)
    {
        $tmp = explode('/', $path);
        for ($i = 0; $i < $level; $i++) {
            array_pop($tmp);
        }
        return implode('/',$tmp);
    }
}