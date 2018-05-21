<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 22/05/2018
 * Time: 12:10 AM
 * ----------------------------------------------------
 */

use PHPUnit\Framework\TestCase;
use camilord\utilus\Numeric\VersionUtilus;

class VersionUtilusTest extends TestCase
{
    /**
     * @param string $version
     * @param string $expected
     * @dataProvider getTestData
     */
    public function testIncrement($version, $expected) {
        $result = VersionUtilus::increment($version);
        $this->assertEquals($result, $expected);
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */
    public function getTestData() {
        return [
            ['', '0.0.1'],
            [null, '0.0.1'],
            [false, '0.0.1'],
            [true, '1.0.1'],
            ['1.0', '1.0.1'],
            ['2.0.999', '2.1.0'],
            ['1.99.999', '2.0.0'],
            ['1.99.34', '1.99.35'],
            ['1', '1.0.1'],
            ['1.34.78', '1.34.79']
        ];
    }
}