<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 12/04/2018
 * Time: 12:25 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\PDF;


/**
 * Class PdfFillable2Flatten
 * @package AlphaOne\PDFGenerator
 */
class PdfFillable2Flatten
{
    private $tmpDir = 'tmp/';

    /**
     * @param string $tmpDir
     */
    public function setTmpDir($tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }

    /**
     * @todo: before you can use this method, you must install PDFTK in your server first.
     * @installation: apt-get install -y pdftk
     * @param string $source_file
     * @param bool $debug
     * @return string
     */
    public function convert($source_file, $debug = false) {

        $output_file = $this->tmpDir.time().'_'.basename($source_file);
        $final_output_file = $this->tmpDir.sha1(time()).'.pdf';

        $cmd1 = 'pdftk "{SOURCE_FILE}" generate_fdf output {OUTPUT_FILE}';
        $cmd2 = 'pdftk "{SOURCE_FILE}" fill_form {OUTPUT_FILE} output "{FINAL_OUTPUT_FILE}" flatten';

        $cmd1 = str_replace([ '{SOURCE_FILE}', '{OUTPUT_FILE}' ], [$source_file, $output_file], $cmd1);
        $cmd2 = str_replace([ '{SOURCE_FILE}', '{OUTPUT_FILE}', '{FINAL_OUTPUT_FILE}' ], [$source_file, $output_file, $final_output_file], $cmd2);

        ob_start();
        @system($cmd1);
        @system($cmd2);
        $cli = ob_get_contents();
        ob_end_clean();

        if ($debug) {
            print_r($cli);
        }

        if (file_exists($final_output_file)) {
            @unlink($output_file);
            return $final_output_file;
        }

        return $source_file;
    }
}