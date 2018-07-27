<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 21/05/2018
 * Time: 11:47 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Numeric;

use PHPUnit\Framework\TestCase;
use camilord\utilus\Numeric\NumericUtilus;

class NumericUtilusTest extends TestCase
{
    public function testLeadingZeroes()
    {
        $this->assertEquals(NumericUtilus::leading_zeroes(1000, 7), '0001000');
        $this->assertEquals(NumericUtilus::leading_zeroes(123456, 20), '00000000000000123456');
    }

    /**
     * @param mixed $val
     * @param string $expected
     * @dataProvider getTestDataCleanNumber
     */
    public function testGetCleanNumber($val, $expected)
    {
        $result = NumericUtilus::getCleanNumber($val);
        $this->assertEquals($result, $expected);
    }

    /**
     * @param mixed $val
     * @param string $expected
     * @dataProvider getTestDataCleanNumberCurrency
     */
    public function testGetCleanNumberCurrency($val, $expected) {
        $result = NumericUtilus::getCleanNumberCurrency($val);
        $this->assertEquals($result, $expected);
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */
    public function getTestDataCleanNumber() {
        return [
            ['1232654.1', '1232654.1'],
            ['1049723', '1049723'],
            ['0004382940832', '4382940832'],
            ['1049723.43.234', '1049723.43'],
            ['1049723.43.234.ds', '1049723.43']
        ];
    }

    public function getTestDataCleanNumberCurrency() {
        return [
            ['1232654.1', '1232654.10'],
            ['1049723', '1049723.00'],
            ['0004382940832', '4382940832.00'],
            ['1049723.43.234', '1049723.43'],
            ['1049723.43.234.ds', '1049723.43']
        ];
    }
}