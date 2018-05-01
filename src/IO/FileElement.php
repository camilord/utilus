<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 2/05/2018
 * Time: 12:09 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\IO;

/**
 * Class FileElement
 * @package camilord\utilus\IO
 */
class FileElement
{
    private $name;
    private $original_name;
    private $path;
    private $ext;
    private $file_path;
    private $size;
    private $type;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getOriginalName()
    {
        return $this->original_name;
    }

    /**
     * @param mixed $original_name
     */
    public function setOriginalName($original_name)
    {
        $this->original_name = $original_name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * @param mixed $ext
     */
    public function setExt($ext)
    {
        $this->ext = $ext;
    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * @param mixed $file_path
     */
    public function setFilePath($file_path)
    {
        $this->file_path = $file_path;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}