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
    /**
     * @param null|string $server_name
     * @return string
     */
    public static function getBaseURL($server_name = null) {
        if (is_null($server_name) || $server_name == '') {
            $server_name = $_SERVER['SERVER_NAME'] ?? false;
        }
        return 'http'.(self::isSSL() ? 's' : '').'://'.$server_name;
    }

    /**
     * @return bool
     */
    public static function isSSL() {
        $secure_connection = false;
        if (
            (isset($_SERVER['HTTPS']) && strlen($_SERVER['HTTPS']) > 0) || 
            (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        ) {
            $secure_connection = true;
        }

        return $secure_connection;
    }

    /**
     * @param string $path1
     * @param string $path2
     * @return mixed|string
     */
    public static function mergeURL($path1, $path2) {
        $merged_path = $path1 . substr($path2, strpos($path2, basename($path1)) + strlen(basename($path1)));
        $merged_path = str_replace(['//', ':/'], ['/', '://'], $merged_path);
        return $merged_path;
    }

    /**
     * @param string $ip
     * @return string
     */
    public static function colourifyIP($ip)
    {
        $parts = explode(".", $ip);
        $color = sprintf("%02s", dechex($parts[1])) .
                 sprintf("%02s", dechex($parts[2])) .
                 sprintf("%02s", dechex($parts[3]));

        return $color;
    }

    public static function getIPAddress(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?: $ip;
        }

        return $ip;
    }

    /**
     * @param string $url1
     * @param string $url2
     * @return bool
     */
    public function is_slightly_the_same(string $url1, string $url2, int $code = 0): bool
    {
        $url1 = preg_replace("/^http(s?):\/\//i", '', $url1);
        $url2 = preg_replace("/^http(s?):\/\//i", '', $url2);

        // if (substr($url1, -1) === '/') {
        //     $url1 = substr($url1, 0, -1);
        // }
        // if (substr($url2, -1) === '/') {
        //     $url2 = substr($url2, 0, -1);
        // }
        $url1 = rtrim($url1, "/");
        $url2 = rtrim($url2, "/");

        // public const HTTP_MOVED_PERMANENTLY = 301;
        if ($code === Response::HTTP_MOVED_PERMANENTLY) 
        {
            $url1 = str_replace('www.', '', $url1);
            $url2 = str_replace('www.', '', $url2);
        }

        if ($url1 !== $url2) {
            return false;
        }

        return true;
    }

}
