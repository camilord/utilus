<?php
/**
 * AlphaOne Building Consent System
 * Copyright Alpha77 Limited | Setak Holdings Limited 2013 - 2019
 * Generated in PhpStorm.
 * Developer: Camilo Lozano III - www.camilord.com
 * Username: AlphaDev1
 * Date: 25 Feb 2019
 * Time: 10:58 AM
 */

namespace camilord\utilus\Net;


use camilord\utilus\IO\ConsoleUtilus;
use camilord\utilus\IO\SystemUtilus;
use camilord\utilus\Security\Sanitizer;

/**
 * Class NetUtilus
 * @package camilord\utilus\Net
 */
class NetUtilus
{
    /**
     * best way to download large file
     * @param string $download_url
     * @param string $destination_download_path
     * @return string
     */
    public function downloadFile($download_url, $destination_download_path = 'tmp/')
    {
        if (!is_dir($destination_download_path)) {
            mkdir($destination_download_path, 0777, true);
        }
        $tmp_file = $destination_download_path.basename($download_url);
        $tmp_file = SystemUtilus::cleanPath($tmp_file);

        $ch = curl_init($download_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        file_put_contents($tmp_file, $data);

        return $tmp_file;
    }

    /**
     * @param $download_url
     * @param string $destination_download_path
     * @return string
     */
    public function downloadLargeFile($download_url, $destination_download_path = 'tmp/')
    {
        if (!is_dir($destination_download_path)) {
            @mkdir($destination_download_path, 0777, true);
        }
        $filename = basename($download_url);
        $filename = Sanitizer::filename_cleaner($filename);
        $path_to_download = $destination_download_path.$filename;

        $cmd = "wget -O {$path_to_download} {$download_url}";
        ConsoleUtilus::shell_exec($cmd);

        return $path_to_download;
    }
}