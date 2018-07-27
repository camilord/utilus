<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 27/07/2018
 * Time: 7:51 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\IO;


use PHPUnit\Framework\TestCase;

class DirectoryUtilTest extends TestCase
{
    /**
     * @param $dir
     * @param $level
     * @param $expected
     * @dataProvider getTestData
     */
    public function testUpLevel($dir, $level, $expected) {
        $result = DirectoryUtil::upLevel($dir, $level);
        $this->assertEquals($expected, $result);
    }

    public function getTestData() {
        return [
            ['/srv/www/sample.com/public', 1, '/srv/www/sample.com'],
            ['/srv/www/sample.com/public', 2, '/srv/www']
        ];
    }
}