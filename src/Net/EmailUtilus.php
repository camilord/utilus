<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 5:49 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Net;


/**
 * Class EmailUtilus
 * @package camilord\utilus\Net
 */
class EmailUtilus
{
    /**
     * @param $fullpath_filename
     * @param null $filename
     * @return bool
     */
    public static function is_email_signature_image($fullpath_filename, $filename = null) {
        if (is_null($filename)) {
            $filename = basename($fullpath_filename);
        } else {
            $filename = basename($filename);
        }
        if (file_exists($fullpath_filename)) {
            $fsize = filesize($fullpath_filename);
            if ($fsize < 102400 && preg_match("/^image[0-9]{1,6}\\.(jpg|jpe|jpeg|gif|png|bmp)/i", $filename)) {
                return true;
            }

            //ab50-4bc5-86f2-313647393804_OutlookEmoji1478930651561_Logo30b94f3cc3694820bd5baa298459f961.jpg.pdf
            if ($fsize < 102400 && preg_match("/[a-z0-9\\-_]*OutlookEmoji[0-9]{10,15}_[a-z0-9\\-_]+\\.(jpg|jpe|jpeg|gif|png|bmp)/i", $filename)) {
                return true;
            }
        }
        return false;
    }
}