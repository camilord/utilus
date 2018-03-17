<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 17/03/2018
 * Time: 5:31 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Net;

/**
 * Class Qurl
 * @package camilord\utilus\Net
 */
class Qurl
{
    /**
     * @param $url
     * @param array $postdata
     * @param bool $str
     * @param null $cookfile
     * @return mixed
     */
    public static function post($url, $postdata = null, $str = false, $cookfile = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        if ($cookfile) {
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookfile);
            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookfile); # SAME cookiefile
        }
        //curl_setopt($curl, CURLOPT_URL, $this->_sys_config['cdn_url'].'/index.php'); # this is where you first time connect - GET method authorization in my case, if you have POST - need to edit code a bit
        //$xxx = curl_exec($curl);
        curl_setopt($curl, CURLOPT_URL, $url); # this is where you are requesting POST-method form results (working with secure connection using cookies after auth)
        curl_setopt($curl, CURLOPT_POST, true);
        if (is_array($postdata) && count($postdata) > 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); # form params that'll be used to get form results
        } else {
            curl_setopt($curl, CURLOPT_POSTFIELDS, array());
        }
        $serverResponse = curl_exec($curl);
        curl_close ($curl);

        if ($str) {
            return $serverResponse;
        } else {
            return json_decode($serverResponse, true);
        }
    }

    /**
     * @param $url
     * @param bool $str
     * @param null $cookfile
     * @return mixed
     */
    public static function get($url, $str = false, $cookfile = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        if ($cookfile) {
            curl_setopt($curl, CURLOPT_COOKIEFILE, $cookfile);
            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookfile); # SAME cookiefile
        }
        //curl_setopt($curl, CURLOPT_URL, $this->_sys_config['cdn_url'].'/index.php'); # this is where you first time connect - GET method authorization in my case, if you have POST - need to edit code a bit
        //$xxx = curl_exec($curl);
        curl_setopt($curl, CURLOPT_URL, $url); # this is where you are requesting POST-method form results (working with secure connection using cookies after auth)
        curl_setopt($curl, CURLOPT_POST, false);
        $serverResponse = curl_exec($curl);
        curl_close ($curl);

        if ($str) {
            return $serverResponse;
        } else {
            return json_decode($serverResponse, true);
        }
    }
}