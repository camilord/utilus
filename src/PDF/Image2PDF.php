<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 6:20 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\PDF;

use camilord\utilus\IO\FileUtilus;

/**
 * Class Image2PDF
 * @package camilord\utilus\PDF
 */
class Image2PDF
{
    /**
     * @todo: install imagemagick (which have the "convert" command) in the server first
     *
     *    apt-get install -y imagemagick
     *
     * @param $filename string
     * @param $output string
     * @return string
     * @throws \Exception
     */
    public function convertImage2PDF($filename, $output) {

        if (strtolower(FileUtilus::get_extension($output)) != 'pdf') {
            throw new \Exception("Error! Output should be a pdf extension!");
        }

        if (preg_match("/image[-_a-zA-Z0-9]*\\.(bmp|gif|jpg|png|jpeg|jpe)$/i", $filename)) {
            return $filename;
        }

        ob_start();
        @system(sprintf('convert "%s" "%s"', $filename, $output), $retval);
        ob_end_clean();

        if (file_exists($output) && filesize($output) > 0)
        {
            return $output;
        }

        return $filename;
    }
}