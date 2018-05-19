<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 19/05/2018
 * Time: 6:09 PM
 * ----------------------------------------------------
 */

use PHPUnit\Framework\TestCase;
use camilord\utilus\Data\ArrayUtilus;

class ArrayUtilusTest extends TestCase
{

    /**
     * @param $data
     * @param $expected
     * @dataProvider getTestDataForHaveData
     */
    public function testHaveData($data, $expected) {
        $result = ArrayUtilus::haveData($data);
        $this->assertEquals($result, $expected);
    }

    /**
     * @param array $data
     * @dataProvider getTestDataRandArrNumKeys
     */
    public function testRemoveArrayNumericKeys($data) {
        $data = ArrayUtilus::removeArrayNumericKeys($data);
        $result = true;
        foreach($data as $key => $val) {
            if (is_numeric($key)) {
                $result = false;
                break;
            }
        }

        $this->assertTrue($result);
    }

    public function testCleanseString() {
        $str = '<script>alert(1)</script>hello world';
        $str = ArrayUtilus::cleanse_string($str);
        $this->assertEquals($str, 'alert(1)hello world');
    }

    public function testCleanse() {
        $str = [
            '<script>alert(1)</script>hello world',
            'hello world <div>honey</div>',
            'test' => 'hello <div>x</div>',
            3 => 'hello <div>x</div>'
        ];
        $expected = [
            'alert(1)hello world',
            'hello world honey',
            'hello x',
            'hello x',
        ];
        $str = ArrayUtilus::cleanse($str);
        $index = 0;
        foreach($str as $key => $item) {
            $this->assertEquals($item, $expected[$index]);
            $index++;
        }
    }

    /**
     * @todo: i am not sure how to test the function...
     */
    public function testFilterArray() {
        $data = [
            'test',
            'world' => 'hello',
            'hello world'
        ];
        $data = ArrayUtilus::filter_array($data, '0');

        $this->assertEquals(count($data),3);
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    /**
     * @return array
     */
    public function getTestDataForHaveData() {
        return [
            [ [], false ],
            [ [ 0 => 1], true ],
            [ null, false ],
            [ false, false ],
            [ '', false ],
            [ [1,2,3], true ]
        ];
    }

    public function getTestDataRandArrNumKeys() {
        return [
            [
                [
                    0 => '1',
                    'ID' => '1',
                    1 => 'John Smith',
                    'Name' => 'John Smith'
                ]
            ],
            [
                [
                    0 => '1',
                    1 => 'John Smith'
                ]
            ],
            [
                [
                    'ID' => '1',
                    'Name' => 'John Smith'
                ]
            ]
        ];
    }

}