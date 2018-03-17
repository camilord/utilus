<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 5:46 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\IO;


class FileUtilus
{
    /**
     * @param $file
     * @return int|null|string
     */
    public static function filesize64($file)
    {
        static $iswin;
        if (!isset($iswin)) {
            $iswin = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN');
        }

        static $exec_works;
        if (!isset($exec_works)) {
            $exec_works = (function_exists('exec') && !ini_get('safe_mode') && @exec('echo EXEC') == 'EXEC');
        }

        // try a shell command
        if ($exec_works) {
            $cmd = ($iswin) ? "for %F in (\"$file\") do @echo %~zF" : "stat -c%s \"$file\"";
            @exec($cmd, $output);
            if (is_array($output) && ctype_digit($size = trim(implode("\n", $output)))) {
                return $size;
            }
        }

        // try the Windows COM interface
        if ($iswin && class_exists("COM")) {
            try {
                $fsobj = new \COM('Scripting.FileSystemObject');
                $f = $fsobj->GetFile( realpath($file) );
                $size = $f->Size;
            } catch (\Exception $e) {
                $size = null;
            }
            if (ctype_digit($size)) {
                return $size;
            }
        }

        // if all else fails
        return filesize($file);
    }

    /**
     * @param $filename string
     * @return string|mixed
     */
    public static function get_extension($filename) {
        $tmp = explode('.',$filename);
        return $tmp[(count($tmp) - 1)];
    }

    /**
     * @param $bytes
     * @param int $decimals
     * @param bool $add_bytes_label
     * @return string
     */
    public static function get_human_filesize($bytes, $decimals = 2, $add_bytes_label = false) {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . (($add_bytes_label) ? @$size[$factor] : '');
    }


}