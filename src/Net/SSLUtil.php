<?php
/**
 * AlphaOne Building Consent System
 * Copyright Alpha77 Limited | Setak Holdings Limited 2013 - 2019
 * Generated in PhpStorm.
 * Developer: Camilo Lozano III - www.camilord.com
 * Username: AlphaDev1
 * Date: 18 Feb 2019
 * Time: 11:48 AM
 */

namespace camilord\utilus\Net;

/**
 * Class SSLUtil - will get information on SSL
 * @package camilord\utilus\Net
 */
class SSLUtil
{
    /**
     * reference: https://stackoverflow.com/questions/6863948/how-to-get-expiry-date-from-the-ssl-certificate-file-in-php
     * @param string $url
     * @return array
     */
    public function getSSLInfo($url)
    {
        $url = $this->sanitizeURL($url);
        try {
            $orignal_parse = @parse_url($url, PHP_URL_HOST);
            $get = @stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
            $read = @stream_socket_client("ssl://".$orignal_parse.":443", $errno, $errstr,30, STREAM_CLIENT_CONNECT, $get);
            $cert = @stream_context_get_params($read);
            $certinfo = @openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        } catch (\Exception $e) {
            $certinfo = [];
        }

        return $certinfo;
    }

    /**
     * will return epoch unit datetime format
     * @param string $url
     * @return int
     */
    public function getSslExpiry($url)
    {
        $ssl_info = $this->getSSLInfo($url);
        return (is_array($ssl_info) && array_key_exists('validTo_time_t', $ssl_info)) ?
            (int)$ssl_info['validTo_time_t'] : 0;
    }

    /**
     * this will return a string expiry date that you can format as well
     * @param string $url
     * @param string $date_format
     * @return false|string|null
     */
    public function getSslExpiryDate($url, $date_format = 'Y-m-d H:i:s')
    {
        $ssl_expiry = $this->getSslExpiry($url);
        if (is_numeric($ssl_expiry) && $ssl_expiry > 0) {
            return date($date_format, $ssl_expiry);
        }

        return null;
    }

    /**
     * number of days left before the expire date
     * @param string $url
     * @return bool|int
     */
    public function getSslDaysLeft($url)
    {
        $days_left = false;
        $ssl_expiry = $this->getSslExpiry($url);

        if (is_numeric($ssl_expiry) && $ssl_expiry > 0)
        {
            $expire_date = date('Y-m-d H:i:s', $ssl_expiry);

            try {
                $ssl_expiry_date = new \DateTime($expire_date);
                $interval = $ssl_expiry_date->diff(new \DateTime(date('Y-m-d H:i:s')));
                $days_left = (int)$interval->format('%a');
            } catch(\Exception $e) {
                $days_left = false;
            }
        }

        return $days_left;
    }

    /**
     * @param string $url
     * @return string
     */
    private function sanitizeURL($url)
    {
        if (stripos($url, '://') === false) {
            return "https://{$url}";
        }

        return $url;
    }
}