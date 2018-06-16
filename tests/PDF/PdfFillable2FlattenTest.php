<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/06/2018
 * Time: 1:06 AM
 * ----------------------------------------------------
 */

namespace PDF;

use camilord\utilus\IO\SystemUtilus;
use camilord\utilus\PDF\PdfFillable2Flatten;
use PHPUnit\Framework\TestCase;

class PdfFillable2FlattenTest extends TestCase
{
    public function testConvert() {

        $filename = dirname(__FILE__).'/TestData/application-for-nz-citizenship-adult.pdf';

        $pdf = new PdfFillable2Flatten();
        $pdf->setTmpDir('tmp/');


        if (SystemUtilus::isWin32()) {
            $this->markTestSkipped("Unit tests applicable for LINUX environment only...");
        }

        $result = $pdf->convert($filename);

        $this->assertFileExists($result);
    }

    public function testConvertDebug() {

        $filename = dirname(__FILE__).'/TestData/application-for-nz-citizenship-adult.pdf';

        $pdf = new PdfFillable2Flatten();
        $pdf->setTmpDir('tmp/');

        if (SystemUtilus::isWin32()) {
            $this->markTestSkipped("Unit tests applicable for LINUX environment only...");
        }

        $result = $pdf->convert($filename, true);

        $this->assertFileExists($result);
    }
}