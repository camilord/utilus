<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 19/05/2018
 * Time: 7:09 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Data;

use PHPUnit\Framework\TestCase;
use camilord\utilus\Data\PaginationUtil;
use AlphaOne\Util\UUID;

class PaginationUtilTest extends TestCase
{
    /**
     * @param array $data
     * @param string $expected1
     * @param string $expected2
     * @param string $expected3
     * @param bool $show_force
     * @dataProvider getTestData
     */
    public function testGeneratePagination($data, $expected1, $expected2, $expected3, $show_force) {
        $total = count($data);
        $offset = 1;
        $max = 5;

        $pagination = PaginationUtil::generatePagination('/', $total, $max, $offset, $args = '', $label = 'Pages: ', $page_range = 10, $show_force);

        if ($pagination == "") {
            $this->assertTrue((($total < $max ? "" : "x") == $pagination));
        } else {
            $this->assertContains($expected1, $pagination, 'OUTPUT: '.$pagination);
            $this->assertContains($expected2, $pagination, 'OUTPUT: '.$pagination);
            $this->assertContains($expected3, $pagination, 'OUTPUT: '.$pagination);
        }

    }

    /**
     * @param array $data
     * @param string $expected1
     * @param string $expected2
     * @param string $expected3
     * @param bool $show_force
     * @dataProvider getTestData
     */
    public function testGeneratePagination5($data, $expected1, $expected2, $expected3, $show_force) {
        $total = count($data);
        $offset = 1;
        $max = 5;

        $pagination = PaginationUtil::generatePaginationBy5('/', $total, $max, $offset);

        if ($pagination == "") {
            $this->assertTrue((($total < $max ? "" : "x") == $pagination));
        } else {
            $this->assertContains($expected1, $pagination, 'OUTPUT: '.$pagination);
            $this->assertContains($expected2, $pagination, 'OUTPUT: '.$pagination);
            $this->assertContains($expected3, $pagination, 'OUTPUT: '.$pagination);
        }
    }

    /**
     * @param array $data
     * @param string $expected1
     * @param string $expected2
     * @param string $expected3
     * @param bool $show_force
     * @dataProvider getTestData
     */
    public function testGeneratePaginationClassic($data, $expected1, $expected2, $expected3, $show_force) {
        $total = count($data);
        $offset = ($total > 100) ? 21 : 1;
        $max = 5;
        $expected2 = ($total > 100) ? 'Showing results 101 to 105' : $expected2;

        $pagination = PaginationUtil::generatePaginationClassic('/', $total, $max, $offset);

        $this->assertContains($expected1, $pagination, 'OUTPUT: '.$pagination);
        $this->assertContains($expected2, $pagination, 'OUTPUT: '.$pagination);
        $this->assertContains($expected3, $pagination, 'OUTPUT: '.$pagination);
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    public function getTestData() {
        $big_data = [];
        for ($i = 1; $i <= 10000; $i++) {
            $big_data[] = [
                'id' => $i,
                'name' => UUID::v4()
            ];
        }
        return [
            [
                $big_data,
                "10000 results",
                "Showing results 1 to 5",
                "offset=2000",
                true
            ],
            [
                [

                    [
                        'id' => 1,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 2,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 3,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 4,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 5,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 6,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 7,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 8,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 9,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 10,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 11,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 12,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 13,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 14,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 15,
                        'name' => 'johnny bravo'
                    ]
                ],
                "15 results",
                "Showing results 1 to 5",
                "offset=3",
                false
            ],
            [
                [
                    [
                        'id' => 1,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 2,
                        'name' => 'johnny bravo'
                    ],
                    [
                        'id' => 3,
                        'name' => 'johnny bravo'
                    ]
                ],
                "3 results",
                "results",
                "results",
                true
            ]
        ];
    }
}