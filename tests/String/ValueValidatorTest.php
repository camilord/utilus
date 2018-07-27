<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/06/2018
 * Time: 3:03 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\String;

use camilord\utilus\String\ValueValidator;
use PHPUnit\Framework\TestCase;

class ValueValidatorTest extends TestCase
{

    /**
     * @param string $val
     * @param bool $expected
     * @dataProvider getTestDataIsTrue
     */
    public function testIsTrue($val, $expected) {
        $result = ValueValidator::is_value_true($val);
        $this->assertEquals($expected, $result, 'DATA: '.print_r([$val, $expected], true));
    }

    /**
     * @return array
     */
    public function getTestDataIsTrue() {
        return [
            [ 'y', true ],
            [ 'yes', true ],
            [ 'true', true ],
            [ '1', true ],
            [ '2', false ],
            [ '0', false ],
            [ '', false ],
            [ null, false ],
            [ 'false', false ],
            [ 'no', false ],
        ];
    }

    /**
     * @param string $date
     * @param string $format
     * @param bool $expected
     * @dataProvider getTestDataValidDate
     */
    public function testValidDate($date, $format, $expected) {
        $result = ValueValidator::is_date_valid($date, $format);
        $this->assertEquals($expected, $result);
    }

    public function getTestDataValidDate() {
        return [
            [ '2018-06-16', 'Y-m-d', true ],
            [ '2018-06-16 00:00:00', 'Y-m-d', false ]
        ];
    }
}