<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/06/2018
 * Time: 2:38 AM
 * ----------------------------------------------------
 */

namespace String;


use camilord\utilus\String\StringUtilus;
use PHPUnit\Framework\TestCase;

class StringUtilusTest extends TestCase
{
    public function testSubstring() {
        $str = 'the quick brown fox jumps over the lazy dog';
        $result = StringUtilus::substring($str, 10);
        $this->assertEquals('the quick ...', $result);
    }

    public function testTruncateMiddle() {
        $str = 'the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog';
        $result = StringUtilus::truncate_middle($str, 50);
        $this->assertEquals('the quick brown fox j... the quick brown fox jumps over the lazy dog the quick brown fox jumps over the lazy dog', $result);
    }

    public function testMergeString() {
        $expected = 'the/quick/brown/fox/jumps/over/the/lazy/dog';
        $str1 = 'the/quick/brown/fox/jumps/over';
        $str2 = 'fox/jumps/over/the/lazy/dog';
        $result = StringUtilus::mergeString($str1, $str2);
        $this->assertEquals($expected, $result);
    }

    public function testTruncatLongWords() {
        $str = 'the quick brown fox jumpsssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss over the lazy dog';
        $result = StringUtilus::truncate_long_words($str, 20);
        $this->assertContains('abbr', $result);
    }

    public function testAdvUcWords() {
        $expected = 'The Quick "Brown" Fox Jumps Over The Lazy Dog';
        $str = 'the quick "brown" fox jumps over the lazy dog';
        $result = StringUtilus::adv_ucwords($str);
        $this->assertEquals($expected, $result);
    }
}