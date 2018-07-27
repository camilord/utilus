<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/06/2018
 * Time: 1:48 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\PDF;

use camilord\utilus\IO\SystemUtilus;
use camilord\utilus\PDF\StandardPdfChecker;
use PHPUnit\Framework\TestCase;

class StandardPdfCheckerTest extends TestCase
{
    public function testTest() {
        if (SystemUtilus::isWin32()) {
            $this->markTestSkipped("Unit tests applicable for LINUX environment only...");
        }

        $pdf = new StandardPdfChecker();
        $pdf->test();
    }

    public function testCacheDir() {
        $pdf = new StandardPdfChecker();
        $pdf->setCachePath($pdf->cwd());

        $this->assertDirectoryExists($pdf->getCachePath());
    }

    public function testBaseDir() {
        $pdf = new StandardPdfChecker();
        $pdf->setBasePath($pdf->cwd());

        $this->assertDirectoryExists($pdf->getBasePath());
    }

    public function testIsStandard() {

        if (SystemUtilus::isWin32()) {
            $this->markTestSkipped("Unit tests applicable for LINUX environment only...");
        }

        $pdf = new StandardPdfChecker();
        $pdf->setCachePath(dirname(__FILE__).'/TestData/');

        $filename = dirname(__FILE__).'/TestData/application-for-nz-citizenship-adult.pdf';
        $result = $pdf->is_standard($filename);
        if (SystemUtilus::isWin32()) {
            $this->assertFalse($result);
        } else {
            $this->assertTrue($result);
        }

    }
}