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
 * apt-get install libreoffice-core --no-install-recommends
 * apt-get install cups-pdf
 * apt-get install unoconv
 *
 * Class PdfConverterFromDocx
 * @package AlphaOne\PDFGenerator
 */
class PdfConverterFromDocx
{
    /**
     * @var string
     */
    private $app_converter;
    /**
     * @var string
     */
    private $save_folder;

    /**
     * PdfConverterFromDocx constructor.
     */
    public function __construct()
    {
        $this->useDoc2Pdf();
        $this->setSaveFolder('tmp/');
    }

    /**
     * @return string
     */
    public function getSaveFolder()
    {
        return $this->save_folder;
    }

    /**
     * @param $save_folder
     * @return $this
     */
    public function setSaveFolder($save_folder)
    {
        $this->save_folder = $save_folder;

        /**
         * if folder does not exists, create it...
         */
        if (!is_dir($this->save_folder)) {
            @mkdir($this->save_folder, 0777, true);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function useLibreOffice() {
        $this->app_converter = 'libreoffice';
        return $this;
    }

    /**
     * @return $this
     */
    public function useCupsPdf() {
        $this->app_converter = 'cupspdf';
        return $this;
    }

    /**
     * @return $this
     */
    public function useDoc2Pdf() {
        $this->app_converter = 'doc2pdf';
        return $this;
    }

    /**
     * @param string $filename
     * @param bool $debug
     * @return bool|mixed|string
     */
    public function convert($filename, $debug = false) {

        if (!file_exists($filename)) {
            return false;
        }

        $output_file = $this->getSaveFolder().sha1(time().rand(100,9999)).'.pdf';

        if ($this->app_converter == 'libreoffice') {
            $cmd = $this->getLibreOfficeCommandSyntax();
            $cmd = str_replace(['{DOCX_FILE}', '{OUTPUT_FILE}'], [$filename, $output_file], $cmd);
        } else if ($this->app_converter == 'cupspdf') {
            $cmd = $this->getCupsPdfCommandSyntax();
            $cmd = str_replace('{DOCX_FILE}', $filename, $cmd);
            $output_file = str_replace([ '.doc', '.docx' ], '.pdf', $filename);
        } else {
            $cmd = $this->getDoc2PdfCommandSyntax();
            $cmd = str_replace('{DOCX_FILE}', $filename, $cmd);
            $output_file = str_replace([ '.doc', '.docx' ], '.pdf', $filename);
        }

        if ($debug) {
            print_r([
                'COMMAND' => $cmd,
                'SOURCE' => $filename,
                'OUTPUT' => $output_file
            ]);
        }

        ob_start();
        @system($cmd);
        $cli = ob_get_contents();
        ob_end_clean();

        if ($debug) {
            print_r($cli);
        }

        if (file_exists($output_file)) {
            return $output_file;
        }

        return $filename;
    }

    /**
     * @todo: before you can use this method, please install the package first.
     *        apt-get install libreoffice-core --no-install-recommends
     *
     * @return string
     */
    private function getLibreOfficeCommandSyntax() {
        $cmd = 'libreoffice --headless -convert-to pdf "{DOCX_FILE}" -outdir "{OUTPUT_FILE}"';
        return $cmd;
    }

    /**
     * @todo: before you can use this method, please install the package first.
     *        apt-get install cups-pdf
     *
     * @return string
     */
    private function getCupsPdfCommandSyntax() {
        $cmd = 'oowriter -pt pdf "{DOCX_FILE}"';
        return $cmd;
    }

    /**
     * @todo: before you can use this method, please install the package first.
     *        apt-get install unoconv
     *
     * @return string
     */
    private function getDoc2PdfCommandSyntax() {
        $cmd = 'doc2pdf "{DOCX_FILE}"';
        return $cmd;
    }
}