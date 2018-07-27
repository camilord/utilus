<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 20/05/2018
 * Time: 5:40 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\IO;

use PHPUnit\Framework\TestCase;
use camilord\utilus\IO\FileElement;

class FileElementTest extends TestCase
{
    /**
     * @var FileElement
     */
    private $obj;
    /**
     * @var string
     */
    private $data;

    public function init() {
        if (!is_object($this->obj)) {
            $this->obj = new FileElement();
        }
    }

    public function testGetName()
    {
        $this->init();
        $this->data = 'test.pdf';
        $this->obj->setName($this->data);

        $this->assertEquals($this->data, $this->obj->getName());
    }

    public function testGetOriginalName() {
        $this->init();
        $this->data = '4320478230947023947902_test.pdf';
        $this->obj->setOriginalName($this->data);

        $this->assertEquals($this->data, $this->obj->getOriginalName());
    }

    public function testGetPath() {
        $this->init();
        $this->data = __FILE__;
        $this->obj->setPath(dirname($this->data));

        $this->assertEquals(dirname($this->data), $this->obj->getPath());
    }

    public function testGetFilePath() {
        $this->init();
        $this->data = __FILE__;
        $this->obj->setFilePath($this->data);

        $this->assertEquals($this->data, $this->obj->getFilePath());
    }

    public function testGetExt() {
        $this->init();
        $this->data = __FILE__;
        $this->obj->setExt($this->data);

        $this->assertEquals($this->data, $this->obj->getExt());
    }

    public function testGetSize() {
        $this->init();
        $this->data = __FILE__;
        $this->obj->setSize(filesize($this->data));

        $this->assertEquals(filesize($this->data), $this->obj->getSize());
    }

    public function testGetType() {
        $this->init();
        $this->data = __FILE__;
        $this->obj->setType(filetype($this->data));

        $this->assertEquals(filetype($this->data), $this->obj->getType());
    }
}