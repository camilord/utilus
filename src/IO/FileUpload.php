<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 5:46 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\IO;

/**
 * Class FileUpload
 * @package camilord\utilus\IO
 */
class FileUpload
{
    /**
     * @var array $_FILES
     */
    private $files;

    /**
     * @var bool
     */
    private $auto_create_tmp_folder;

    /**
     * @var string - where you upload temporarily
     */
    private $tmp_dir_location = '/tmp/';

    /**
     * FileUpload constructor.
     * @param null|array $files - $_FILES
     * @param bool $auto_create_tmp_folder
     */
    public function __construct($files = null, $auto_create_tmp_folder = false)
    {
        $this->files = (!is_null($files)) ? $files : $_FILES;
        $this->auto_create_tmp_folder = $auto_create_tmp_folder;

        $this->createTempDir();
    }

    /**
     * @param string $dir path
     * @param bool $auto_create_tmp_folder
     */
    public function setTemporaryUploadDir($dir, $auto_create_tmp_folder = false)
    {
        $this->tmp_dir_location = $dir;
        $this->auto_create_tmp_folder = $auto_create_tmp_folder;
        $this->createTempDir();
    }

    /**
     * create tmp file
     */
    private function createTempDir()
    {
        if ($this->auto_create_tmp_folder === true && !is_dir($this->tmp_dir_location))
        {
            mkdir($this->tmp_dir_location, 0775, true);
        }
    }

    /**
     * @param string $file_element -> $_FILES index variable or key value of the array
     * @return bool|FileElement
     */
    public function processUpload($file_element)
    {
        if (isset($this->files[$file_element]) && is_array($this->files[$file_element]) && count($this->files[$file_element]) > 0)
        {
            $new_filename = $this->tmp_dir_location.'/tmp_'.sha1(time().rand(1,99999)).'_'.time().'.{FILE_EXT}';

            $file_ext = FileUtilus::get_extension($this->files[$file_element]['name']);
            $new_filename = str_replace('{FILE_EXT}', strtolower($file_ext), $new_filename);
            move_uploaded_file($this->files[$file_element]['tmp_name'], $new_filename);

            if (file_exists($new_filename))
            {
                $fileObj = new FileElement();
                $fileObj->setName(basename($new_filename));
                $fileObj->setOriginalName(basename($this->files[$file_element]['name']));
                $fileObj->setPath(dirname($new_filename));
                $fileObj->setExt(strtolower($file_ext));
                $fileObj->setFilePath($new_filename);
                $fileObj->setSize(filesize($new_filename));
                $fileObj->setType($this->files[$file_element]['type']);

                return $fileObj;

            } else {
                return false;
            }

        } else {
            return false;
        }
    }
}
