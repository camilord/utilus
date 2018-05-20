<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 20/05/2018
 * Time: 6:39 PM
 * ----------------------------------------------------
 */

use PHPUnit\Framework\TestCase;
use camilord\utilus\IO\FileUtilus;

class FileUtilusTest extends TestCase
{
    private $test_filename = 'TestData/composer.txt';

    public function testGetExtension() {
        $file_ext = FileUtilus::get_extension($this->test_filename);
        $this->assertEquals($file_ext, 'txt');
    }

    public function testFilesize64() {
        $filename = dirname(__FILE__).'/'.$this->test_filename;
        $size = filesize($filename);
        $size64 = FileUtilus::filesize64($filename);

        $this->assertEquals($size64, $size);
    }

    /**
     * @param int $decimal
     * @param string $sufx
     * @param string $expected
     * @dataProvider getTestData
     */
    public function testGetHumanFilesize($decimal, $sufx, $expected) {
        $filename = dirname(__FILE__).'/'.$this->test_filename;
        $size = filesize($filename);

        $hsize = FileUtilus::get_human_filesize($size, $decimal, $sufx);
        $this->assertEquals($hsize, $expected);
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    public function getTestData() {
        return [
            [1, true, '61.7kB'],
            [4, false, '61.7334'],
            [2, true, '61.73kB']
        ];
    }
}