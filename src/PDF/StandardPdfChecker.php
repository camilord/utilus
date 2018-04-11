<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 6:01 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\PDF;

/**
 * Class StandardPdfChecker
 * @package camilord\utilus\PDF
 */
class StandardPdfChecker
{
    private $_pdf_file;
    private $_last_line;
    private $_command;
    private $_cache_path = 'cache';
    private $_tmp_file = '';
    private $_root_doc_path;
    private $_pdf_test_file;
    private $_base_path;

    /**
     * @return string
     */
    public function cwd() {
        if (!__DIR__) {
            return dirname(__FILE__);
        } else {
            return __DIR__;
        }
    }

    /**
     * @return string
     */
    public function getCachePath()
    {
        return $this->_cache_path;
    }

    /**
     * @param string $cache_path
     * @return $this
     */
    public function setCachePath($cache_path)
    {
        $this->_cache_path = $cache_path;
        $this->_tmp_file = 'tmp_'.sha1(time().rand(100,9999).rand(1000,9999)).'.pdf';
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->_base_path;
    }

    /**
     * @param mixed $base_path
     */
    public function setBasePath($base_path)
    {
        $this->_base_path = $base_path;
    }

    /**
     * initiate variables...
     */
    private function prepare() {

        $this->_root_doc_path = $this->getBasePath();
        if (!is_dir($this->getCachePath())) {
            $this->_cache_path = $this->_root_doc_path.'/cache/';
            if (!is_dir($this->_cache_path)) {
                @mkdir($this->_cache_path, 0777, true);
            }
        }

        $this->_tmp_file = $this->_cache_path.'pdf_checker_'.sha1(time()).'.pdf';
        $this->_pdf_test_file = __DIR__.'/Sample/AlphaOneTestPDF.pdf';

        $this->_command = "pdftk {INPUT_FILES} output {OUTPUT_FILE} verbose";
        $input_files = '"'.$this->_pdf_test_file.'" "'.$this->_pdf_file.'"';

        $this->_command = str_replace('{INPUT_FILES}', $input_files, $this->_command);
        $this->_command = str_replace('{OUTPUT_FILE}', '"'.$this->_tmp_file.'"', $this->_command);
    }

    /**
     * to test this class and print the result
     */
    public function test() {
        echo '<pre>';
        if (function_exists('system')) {
            $cmd = "gs -v";
            $retVal = null;
            ob_start();
            $result = system($cmd, $retVal);
            ob_clean();
            if (preg_match("/copyright/", strtolower($result))) {
                echo "Ghostscript is installed! \n".$result;
            } else {
                echo 'Ghostscript or "gs" command does not exists or not installed!';
            }
        } else {
            echo 'PHP "system" command does not exists or disabled!';
        }
        echo '</pre>';
    }

    /**
     * @param $pdf_file - must be full path and the filename
     * @return bool
     * @desc: cehck if the pdf is standard or not...
     */
    public function is_standard($pdf_file) {
        if (file_exists($pdf_file)) {
            $this->_pdf_file = $pdf_file;
            if ($this->_cache_path == 'cache' || !$this->_cache_path) {
                $this->_cache_path = dirname($this->_pdf_file);
            }

            $retVal = null;
            $this->prepare();

            if (function_exists('system')) {
                ob_start();
                $this->_last_line = system($this->_command, $retVal);
                ob_clean();
                if (file_exists($this->_tmp_file)) {
                    @unlink($this->_tmp_file);
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                $this->_last_line = 'PHP system command does not exists!';
                return TRUE;
            }
        } else {
            $this->_last_line = 'File does not exists!';
            return FALSE;
        }
    }

    /**
     * @return mixed|string
     */
    public function get_result() {
        return $this->_last_line;
    }

    /**
     * @param string $pdf_file - full path and file
     * @return mixed|null
     */
    public function mime_type($pdf_file) {
        if (file_exists($pdf_file)) {
            $this->_pdf_file = $pdf_file;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $this->_pdf_file);
            finfo_close($finfo);
            return $mime_type;
        }
        return null;
    }
}