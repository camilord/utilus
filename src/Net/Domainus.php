<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 5:42 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Net;

/**
 * Class Domainus
 * @package camilord\utilus\Net
 */
class Domainus
{
    public static function getBaseURL($server_name = null) {
        if (is_null($server_name) || $server_name == '') {
            $server_name = $_SERVER['SERVER_NAME'];
        }
        return 'http'.((isset($_SERVER['HTTPS'])) ? 's' : '').'://'.$server_name;
    }

    public static function isSSL() {
        $secure_connection = false;
        if(isset($_SERVER['HTTPS']) || $_SERVER['SERVER_PORT'] == 443) {
            $secure_connection = true;
        }

        return $secure_connection;
    }

    public static function mergeURL($path1, $path2) {
        $merged_path = $path1 . substr($path2, strpos($path2, basename($path1)) + strlen(basename($path1)));
        $merged_path = str_replace(['//', ':/'], ['/', '://'], $merged_path);
        return $merged_path;
    }

}