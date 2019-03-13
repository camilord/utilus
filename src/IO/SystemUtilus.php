<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 14/06/2018
 * Time: 10:38 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\IO;

/**
 * Class SystemUtilus
 * @package camilord\utilus\IO
 */
class SystemUtilus
{
    /**
     * @return float|int
     */
    public static function getFileUploadMaxSize() {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $max_size = FileUtilus::get_human_filesize(ini_get('post_max_size'));

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = FileUtilus::get_human_filesize(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }

    /**
     * @return bool
     */
    public static function isWin32() {
        return (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN');
    }

    /**
     * @param string $path
     * @return string
     */
    public static function cleanPath($path) {
        $max = count(explode('/', $path));
        for ($i = 0; $i < $max; $i++) {
            $path = str_replace('\\', '/', $path);
            $path = str_replace('//', '/', $path);
        }
        return $path;
    }
}