<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 21/05/2018
 * Time: 10:51 PM
 * ----------------------------------------------------
 */

use PHPUnit\Framework\TestCase;
use camilord\utilus\Net\Qurl;

class QurlTest extends TestCase
{
    /**
     * @param string $url
     * @param array $post_vars
     * @param bool $str_rtn
     * @param string $cookfile
     * @dataProvider getTestDataForPost
     */
    public function testPost($url, $post_vars, $str_rtn, $cookfile) {

        $response = Qurl::post($url, $post_vars, $str_rtn, $cookfile);

        if ($str_rtn) {
            $this->assertJson($response);
            $response = json_decode($response, true);
        }

        $this->assertArrayHasKey('result', $response);
        if (isset($post_vars['uname'])) {
            $this->assertFalse($response['result']);
            $this->assertArrayHasKey('message', $response);
        } else {
            $this->assertTrue($response['result']);
            $this->assertArrayHasKey('username', $response);
            $this->assertArrayHasKey('password', $response);
        }
    }

    /**
     * @param string $url
     * @param array $get_vars
     * @param bool $str_rtn
     * @param string $cookfile
     * @dataProvider getTestDataForGet
     */
    public function testGet($url, $get_vars, $str_rtn, $cookfile)
    {
        $get_params = http_build_query($get_vars);
        $get_params = str_replace(['%5B0', '%5B1', '%5B2'], '[', $get_params);
        $get_params = str_replace('%5D', ']', $get_params);
        $get_params = str_replace('%2B', '+', $get_params);

        $response = Qurl::get($url.'?'.$get_params, $str_rtn, $cookfile);

        if ($str_rtn) {
            $this->assertJson($response);
            $response = json_decode($response, true);
        }

        $this->assertArrayHasKey('content', $response);
        $this->assertArrayHasKey('summary', $response);
        $this->assertArrayHasKey('list', $response);
        $this->assertArrayHasKey('keyword', $response);

        $this->assertContains($response['keyword'], $response['content']);
        $this->assertContains($response['keyword'], $response['summary']);
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */
    public function getTestDataForPost() {
        return [
            [
                'http://camilord.com/demo/post.php',
                [
                    'username' => 'johnny.bravo',
                    'password' => 'secret'
                ],
                false,
                null
            ],
            [
                'http://camilord.com/demo/post.php',
                [
                    'uname' => 'johnny.bravo',
                    'passwd' => 'secret'
                ],
                false,
                null
            ],
            [
                'http://camilord.com/demo/post.php',
                [
                    'username' => 'johnny.bravo',
                    'password' => 'secret'
                ],
                true,
                null
            ],
            [
                'http://camilord.com/demo/post.php',
                [
                    'uname' => 'johnny.bravo',
                    'passwd' => 'secret'
                ],
                true,
                null
            ],
            [
                'http://camilord.com/demo/post.php',
                [
                    'username' => 'johnny.bravo',
                    'password' => 'secret'
                ],
                true,
                'test.cookie'
            ],
            [
                'http://camilord.com/demo/post.php',
                [
                    'uname' => 'johnny.bravo',
                    'passwd' => 'secret'
                ],
                false,
                'test.cookie'
            ]
        ];
    }

    public function getTestDataForGet() {
        // keyword=pc+fan&category=companies&filters[]=REGISTERED&filters[]=REMOVED&filters[]=EXTERNAL_ADMINISTRATION&ajax=true
        return [
            ['https://companies-register.companiesoffice.govt.nz/search/',
                [
                    'keyword' => 'pc+fanatic',
                    'category' => 'companies',
                    'filters' => [
                        'REGISTERED', 'REMOVED', 'EXTERNAL_ADMINISTRATION'
                    ],
                    'ajax' => 'true'
                ],
                false,
                null
            ],
            ['https://companies-register.companiesoffice.govt.nz/search/',
                [
                    'keyword' => 'mermaid',
                    'category' => 'companies',
                    'filters' => [
                        'REGISTERED', 'REMOVED', 'EXTERNAL_ADMINISTRATION'
                    ],
                    'ajax' => 'true'
                ],
                false,
                null
            ],
            ['https://companies-register.companiesoffice.govt.nz/search/',
                [
                    'keyword' => 'pc+fanatic',
                    'category' => 'companies',
                    'filters' => [
                        'REGISTERED', 'REMOVED', 'EXTERNAL_ADMINISTRATION'
                    ],
                    'ajax' => 'true'
                ],
                true,
                null
            ],
            ['https://companies-register.companiesoffice.govt.nz/search/',
                [
                    'keyword' => 'mermaid',
                    'category' => 'companies',
                    'filters' => [
                        'REGISTERED', 'REMOVED', 'EXTERNAL_ADMINISTRATION'
                    ],
                    'ajax' => 'true'
                ],
                true,
                null
            ],
            ['https://companies-register.companiesoffice.govt.nz/search/',
                [
                    'keyword' => 'mermaid',
                    'category' => 'companies',
                    'filters' => [
                        'REGISTERED', 'REMOVED', 'EXTERNAL_ADMINISTRATION'
                    ],
                    'ajax' => 'true'
                ],
                false,
                'test.cookie'
            ],
            ['https://companies-register.companiesoffice.govt.nz/search/',
                [
                    'keyword' => 'pc+fanatic',
                    'category' => 'companies',
                    'filters' => [
                        'REGISTERED', 'REMOVED', 'EXTERNAL_ADMINISTRATION'
                    ],
                    'ajax' => 'true'
                ],
                true,
                'test.cookie'
            ]
        ];
    }
}