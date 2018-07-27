<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 19/05/2018
 * Time: 3:54 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Algorithm;

use PHPUnit\Framework\TestCase;
use camilord\utilus\Algorithm\UUID;

class UUIDTest extends TestCase
{
    /**
     * uuid validity
     */
    public function testIsValidUUID() {
        $uuid = UUID::v4();
        $this->assertTrue(UUID::is_valid($uuid));

        $uuid = str_replace('-', '', UUID::v4());
        $this->assertTrue(UUID::is_valid($uuid));

        $uuid = '1546058x5a25433485aee68f2a44bbaf';
        $this->assertFalse(UUID::is_valid($uuid));

        $uuid = '1546058f-5a25-4334-85ae-e68f2a44bbaz';
        $this->assertFalse(UUID::is_valid($uuid));
    }

    /**
     * @param string $val1
     * @param string $val2
     * @param string $expected
     * @dataProvider getTestDataC3rd
     */
    public function testVC3rd($val1, $val2, $expected) {

        $uuid = UUID::vC3rd($val1, $val2);
        $this->assertTrue(UUID::is_valid($uuid));
        $this->assertEquals($uuid, $expected);
    }

    /**
     * @param string $namespace
     * @param string $str
     * @param string $expected
     * @dataProvider getTestDataNamedBasedV3
     */
    public function testV3($namespace, $str, $expected) {
        $uuid = UUID::v3($namespace, $str);
        $this->assertTrue(UUID::is_valid($uuid));
        $this->assertEquals($uuid, $expected);
    }

    /**
     * @param string $namespace
     * @param string $str
     * @param string $expected
     * @dataProvider getTestDataNamedBasedV5
     */
    public function testV5($namespace, $str, $expected) {
        $uuid = UUID::v5($namespace, $str);
        $this->assertTrue(UUID::is_valid($uuid));
        $this->assertEquals($uuid, $expected);
    }

    public function testV4() {
        $uuid = UUID::v4();
        $this->assertTrue(UUID::is_valid($uuid));
    }

    public function testRandomUUID() {
        $uuid = UUID::getRandomUUID();
        $this->assertTrue(UUID::is_valid($uuid));
    }


    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    /**
     * @return array
     */
    public function getTestDataC3rd() {
        return [
            ['Test1', 'Exampl1', 'b9ef0e9e-3249-31a1-a529-640a129890ac'],
            ['Test1{}', 'Exampl1{}', 'bee6ce5a-c8b2-3557-9ba8-ad9a7fd644ff'],
            ['Test1_Tester()', 'Exampl1_Tester()', '0072e993-9fe8-38c2-bbb9-84f1dfbc38a6'],
            ['LuHmHins6AOn', 's1CyZtXnMRHBlawi6l0g6IPiTlHLra8D', 'd8653b3a-fbb3-3eaf-b6e2-25abd226e9ad'],
            ['UoZ5r!yN', '^NJOLycZuqMNl$Sj#btE27UVB#G#HVw^', '70dd5ce6-ef0c-3edb-8baf-2975d576e976'],
            ['wNn#L22n', '(f3efXov8S!6oKmxYJKbR)IghzG_pmUowvs9Umc00*Gr4WYUiNZ59Rc&^DW*!#BF', 'c45f8551-0e78-3195-835b-1647ffa9c6f6'],
        ];
    }

    public function getTestDataNamedBasedV3() {
        return [
            ['1546058f-5a25-4334-85ae-e68f2a44bbaf', 'OMegWUk2mQr8', '28cfa251-9358-37a8-849d-44aee57bcd83'],
            ['1546058f-5a25-4334-85ae-e68f2a44bbaf', 'ranIdY2ScU5c', '8e616a59-76a8-3c62-9493-504f72511e64'],
            ['1546058f-5a25-4334-85ae-e68f2a44bbaf', '2R09vOI0gvUn', 'ff44d6e0-8a76-3536-ae24-c4843d8cff28']
        ];
    }

    public function getTestDataNamedBasedV5() {
        return [
            ['1546058f-5a25-4334-85ae-e68f2a44bbaf', 'OMegWUk2mQr8', 'bd11bce3-a0e8-5729-ac5a-3fdc2deb65d1'],
            ['1546058f-5a25-4334-85ae-e68f2a44bbaf', 'ranIdY2ScU5c', '6459a352-d255-5357-bf95-92a4a1401ce2'],
            ['1546058f-5a25-4334-85ae-e68f2a44bbaf', '2R09vOI0gvUn', '5b559417-6207-5511-bb0e-7dca4c22feab']
        ];
    }
}