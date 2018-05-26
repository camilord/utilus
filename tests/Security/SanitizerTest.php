<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 27/05/2018
 * Time: 1:31 AM
 * ----------------------------------------------------
 */

use PHPUnit\Framework\TestCase;
use camilord\utilus\Security\Sanitizer;

class SanitizerTest extends TestCase
{
    /**
     * @param string $dirtyString
     * @param string $expected
     * @dataProvider getTestDataEscapeString
     */
    public function testRealEscapeString($dirtyString, $expected)
    {
        $cleanString = Sanitizer::real_escape_string($dirtyString);
        $this->assertEquals($cleanString, $expected);
    }

    public function getTestDataEscapeString() {
        return [
            [ "the quick brown fox jumps\x00 over the lazy dog\r\n", "the quick brown fox jumps\\0 over the lazy dog\\r\\n" ],
            [ "the quick brown fox jumps\\ over 'the lazy' dog\x1a", "the quick brown fox jumps\\\\ over \'the lazy\' dog\\Z" ],
            [ 'the "big" treat', 'the \"big\" treat' ]
        ];
    }
}