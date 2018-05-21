<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 21/05/2018
 * Time: 10:32 PM
 * ----------------------------------------------------
 */

use PHPUnit\Framework\TestCase;
use camilord\utilus\Net\MobileNumberValidator;

class MobileNumberValidatorTest extends TestCase
{

    /**
     * @param string $mobile
     * @param string $expected
     * @dataProvider getTestData
     */
    public function testVerifyNzMobile($mobile, $expected)
    {
        $result = MobileNumberValidator::verify_nz_mobile($mobile);
        $this->assertEquals($result['verification'], $expected);
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */
    public function getTestData() {
        return [
            ['022046111', 'PASSED'],
            ['01913211110', 'FAILED'],
            ['027001122', 'PASSED'],
            ['092245874', 'FAILED'],
            ['063211075166', 'FAILED'],
            ['0063125478', 'FAILED'],
            ['063221259874', 'FAILED'],
            ['9897878444', 'FAILED'],
            ['0253145874', 'PASSED'],
            ['12458745632', 'FAILED']
        ];
    }
}