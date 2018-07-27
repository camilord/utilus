<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 20/05/2018
 * Time: 6:10 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\IO;

use PHPUnit\Framework\TestCase;
use camilord\utilus\IO\FileUpload;

class FileUploadTest extends TestCase
{
    public function testProcessUpload() {
        $testFile = str_replace('\\', '/', dirname(__FILE__)).'/TestData/composer.tmp';
        $tmpFile ='/tmp/php1h4j1o';
        @mkdir(dirname($tmpFile), 0777, true);
        @copy($testFile, $tmpFile);

        $_FILES = [
            'document_name' => [
                'name' => 'composer.lock',
                'type' => 'txt/plain',
                'tmp_name' => $tmpFile,
                'error' => 0,
                'size' => filesize($tmpFile)
            ]
        ];
        $tmp_dir = str_replace('\\', '/', dirname(__FILE__)).'/TestData/'.date('Ymd');


        $uploader = new FileUpload($_FILES);
        $uploader->setTemporaryUploadDir($tmp_dir, true);
        $fileObj = $uploader->processUpload('document_name');

        if ($fileObj === false) {
            $this->assertFalse($fileObj);
        } else {
            $this->assertDirectoryExists($tmp_dir);
            $this->assertFileExists($fileObj->getFilePath());

            $this->assertTrue((unlink($fileObj->getFilePath())));
            $this->assertTrue((rmdir($tmp_dir)));
        }

        @unlink($tmpFile);
    }
}