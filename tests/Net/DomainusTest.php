<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 20/05/2018
 * Time: 10:20 PM
 * ----------------------------------------------------
 */

use PHPUnit\Framework\TestCase;
use camilord\utilus\Net\Domainus;

class DomainusTest extends TestCase
{
    public function testGetBaseURL()
    {
        $is_ssl = isset($_SERVER['HTTPS']);
        $base_domain = Domainus::getBaseURL('localhost');

        if ($is_ssl) {
            $this->assertEquals($base_domain, 'https://localhost');
        } else {
            $this->assertEquals($base_domain, 'http://localhost');
        }
    }

    public function testIsSSL()
    {
        $is_ssl = isset($_SERVER['HTTPS']);
        $ssl = Domainus::isSSL();

        $this->assertEquals($ssl, $is_ssl);
    }

    /**
     * @param string $url1
     * @param string $url2
     * @param string $expected
     * @dataProvider getTestData
     */
    public function testMergeURL($url1, $url2, $expected)
    {
        $result = Domainus::mergeURL($url1, $url2);

        $this->assertEquals($result, $expected);
    }

    /**
     * @param string $ip
     * @param string $expected
     * @dataProvider getTestColors
     */
    public function testColorifyIP($ip, $expected)
    {
        $colored_ip = Domainus::colourifyIP($ip);

        $this->assertEquals($colored_ip, $expected);
    }


    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    public function getTestData() {
        return [
            ['http://localhost/test/', '/test/url?t=1234', 'http://localhost/test/url?t=1234'],
            ['/srv/data/prod', '/prod/council', '/srv/data/prod/council'],
        ];
    }

    public function getTestColors() {
        return [
            ['192.168.0.1', 'a80001'],
            ['120.138.20.119', '8a1477'],
            ['127.0.0.1', '000001']
        ];
    }
}