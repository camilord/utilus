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

use camilord\utilus\Data\ArrayUtilus;

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
     * @return string
     */
    public static function getPlatformCode() {
        return strtoupper(substr(PHP_OS, 0, 3));
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

    /**
     * @param string $cmd
     * @return bool
     */
    public static function command_exists($cmd) {
        $return = shell_exec(sprintf("which %s", escapeshellarg($cmd)));
        return !empty($return);
    }

    /**
     * @return array - mac address could be multiple interfaces, so its array
     */
    public static function getHostMacAddress()
    {
        ob_start();
        if (self::isWin32()) {
            system('ipconfig /all');
        } else {
            system('ifconfig');
        }
        $ip_config_data = ob_get_contents();
        ob_end_clean();

        // preg_match("/([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}/", $ip_config_data, $matches);
        if (self::isWin32()) {
            preg_match_all("/[a-fA-F0-9]{2}\\-[a-fA-F0-9]{2}\\-[a-fA-F0-9]{2}\\-[a-fA-F0-9]{2}\\-[a-fA-F0-9]{2}\\-[a-fA-F0-9]{2}/", $ip_config_data, $matches);
        } else {
            preg_match_all("/[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}:[a-fA-F0-9]{2}/", $ip_config_data, $matches);
        }

        $mac_addresses = [];
        foreach($matches as $mac_address)
        {
            if (ArrayUtilus::haveData($mac_address)) {
                foreach($mac_address as $item) {
                    $item = str_replace('-', ':', $item);
                    if (filter_var($item, FILTER_VALIDATE_MAC) && $item !== '00:00:00:00:00:00') {
                        $mac_addresses[] = $item;
                    }
                }
            } else {
                $mac_address = str_replace('-', ':', $mac_address);
                if (filter_var($mac_address, FILTER_VALIDATE_MAC) && $mac_address !== '00:00:00:00:00:00') {
                    $mac_addresses[] = $mac_address;
                }
            }
        }

        return $mac_addresses;
    }
}