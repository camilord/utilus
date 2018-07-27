<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/06/2018
 * Time: 2:45 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\String;

use camilord\utilus\String\URIUtilus;
use PHPUnit\Framework\TestCase;

class URIUtilusTest extends TestCase
{
    public function testGetAll() {
        $_SERVER['REQUEST_URI'] = '/jobs/123456/processing/rfi/check';
        $uri = new URIUtilus();

        $tmp = explode('/', substr($_SERVER['REQUEST_URI'], 1));
        foreach($tmp as $item) {
            $this->assertTrue(in_array($item, $uri->getAll()), 'Looking for "'.$item.'" in ['.print_r($uri->getAll(), true).']');
        }
    }

    public function testGetUri(){
        $_SERVER['REQUEST_URI'] = '/jobs/123456/processing/rfi/check';
        $uri = new URIUtilus();

        $tmp = explode('/', substr($_SERVER['REQUEST_URI'], 1));
        foreach($tmp as $i => $item) {
            $this->assertEquals($item, $uri->getURI($i));
        }
    }
}