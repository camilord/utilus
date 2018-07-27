<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 22/05/2018
 * Time: 12:25 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\PDF;

use PHPUnit\Framework\TestCase;
use camilord\utilus\PDF\Image2PDF;
use camilord\utilus\IO\SystemUtilus;

class Image2PDFTest extends TestCase
{
    public function testConvertImage2PDF()
    {
        if (SystemUtilus::isWin32()) {
            $this->markTestSkipped("Unit tests applicable for LINUX environment only...");
        }

        $img2pdf = new Image2PDF();
        $dir = str_replace('\\', '/', dirname(__FILE__).'/TestData/');

        $img = $dir.'Sample.png';
        $output = $dir.'Test.pdf';

        $this->assertFileExists($img);
        $result = $img2pdf->convertImage2PDF($img, $output);

        if (file_exists($output)) {
            $this->assertFileExists($output);
            $this->assertEquals(basename($result), basename($output));
            @unlink($output);
        } else {
            $this->assertEquals(basename($result), basename($img));
        }

        /**
         * if image is MS signature, do not convert...
         */

        $img = $dir.'image001.png';
        $output = $dir.'Test.pdf';
        $result = $img2pdf->convertImage2PDF($img, $output);

        $this->assertEquals(basename($result), basename($img));
    }

    /**
     * @expectedException Exception
     */
    public function testConvertException() {

        if (SystemUtilus::isWin32()) {
            $this->markTestSkipped("Unit tests applicable for LINUX environment only...");
        }

        $img2pdf = new Image2PDF();
        $dir = str_replace('\\', '/', dirname(__FILE__).'/TestData/');
        /**
         * incorrect output, test thrown exeption
         */

        $img = $dir.'image001.png';
        $output = $dir.'Test.docx';
        //$this->expectException(Exception::class);
        $img2pdf->convertImage2PDF($img, $output);
    }
}