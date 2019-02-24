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


use camilord\utilus\IO\SystemUtilus;

class NetUtilus
{
    /**
     * best way to download large file
     * @param string $amazon_s3_url
     * @param string $destination_download_path
     * @return string
     */
    public function downloadFile($amazon_s3_url, $destination_download_path = 'tmp/')
    {
        if (!is_dir($destination_download_path)) {
            @mkdir($destination_download_path, 0777, true);
        }
        $tmp_file = $destination_download_path.basename($amazon_s3_url);
        $tmp_file = SystemUtilus::cleanPath($tmp_file);

        $ch = curl_init($amazon_s3_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        file_put_contents($tmp_file, $data);

        return $tmp_file;
    }
}