<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 6:07 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\String;

/**
 * Class URIUtilus
 * @package camilord\utilus\String
 */
class URIUtilus
{
    /**
     * @var array
     */
    private $segments;

    /**
     * URIUtilus constructor.
     */
    function __construct()
    {
        $this->segments = isset($_SERVER['REQUEST_URI']) ? explode('/', substr($_SERVER['REQUEST_URI'],1,strlen($_SERVER['REQUEST_URI']))) : [];
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function getURI($index)
    {
        return $this->segments[$index] ?? null;
    }

    /**
     * @return array
     */
    public function getAll() {
        return $this->segments;
    }
}