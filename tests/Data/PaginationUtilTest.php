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

use PHPUnit\Framework\TestCase;
use camilord\utilus\Data\PaginationUtil;

class PaginationUtilTest extends TestCase
{
    /**
     * @param array $data
     * @dataProvider getTestData
     */
    public function testGeneratePagination($data) {
        $total = count($data);
        $offset = 0;
        $max = 5;

        $pagination = PaginationUtil::generatePagination('/', $total, $max, $offset);

    }

    /**
     * @param array $data
     * @dataProvider getTestData
     */
    public function testGeneratePagination5($data) {

    }

    /**
     * @param array $data
     * @dataProvider getTestData
     */
    public function testGeneratePaginationClassic($data) {

    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    public function getTestData() {

    }
}