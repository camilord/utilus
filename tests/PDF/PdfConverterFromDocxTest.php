<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 22/05/2018
 * Time: 12:55 AM
 * ----------------------------------------------------
 */

use PHPUnit\Framework\TestCase;
use camilord\utilus\PDF\PdfConverterFromDocx;

class PdfConverterFromDocxTest extends TestCase
{
    public function testConvert()
    {
        $dir = str_replace('\\', '/', dirname(__FILE__).'/TestData/');
        $docfile = $dir.'Samba_ADDC.docx';

        $pdfConvert = new PdfConverterFromDocx();

        $pdfConvert->setSaveFolder($dir);
        $save_folder = $pdfConvert->getSaveFolder();
        $this->assertEquals($save_folder, $dir);

        $this->assertFalse($pdfConvert->convert('wohoho.docx'));

        $pdfConvert->useCupsPdf();
        $result = $pdfConvert->convert($docfile);
        if ($docfile == $result) {
            $this->assertFileExists($result);
        } else {
            $this->assertFileExists($result);
            $this->assertTrue(preg_match("/\\.pdf/i", $result));
        }

        $pdfConvert->useLibreOffice();
        $result = $pdfConvert->convert($docfile);
        if ($docfile == $result) {
            $this->assertFileExists($result);
        } else {
            $this->assertFileExists($result);
            $this->assertTrue(preg_match("/\\.pdf/i", $result));
        }

        $pdfConvert->useDoc2Pdf();
        $result = $pdfConvert->convert($docfile);
        if ($docfile == $result) {
            $this->assertFileExists($result);
        } else {
            $this->assertFileExists($result);
            $this->assertTrue(preg_match("/\\.pdf/i", $result));
        }
    }
}