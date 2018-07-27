<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 20/05/2018
 * Time: 1:45 PM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Database;

use PHPUnit\Framework\TestCase;
use camilord\utilus\Database\QueryDriver;
use camilord\utilus\Database\QueryResult;
use Doctrine\DBAL\Driver\Mysqli\Driver;
use Doctrine\DBAL\Connection;

class QueryResultTest extends TestCase
{
    /**
     * @return QueryDriver
     */
    private function initConnection() {

        $db_options = array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'test',
            'user'      => 'root',
            'password'  => 'secret',
            'port'      => 3306,
            'charset'   => 'utf8',
        );

        $driver = new Driver($db_options);
        $db = new Connection($db_options, $driver);

        $query_driver = new QueryDriver($db);

        return $query_driver;
    }

    /**
     * @param string $q
     * @param int $expected_count
     * @dataProvider getTestData
     */
    public function testGetData($q, $expected_count)
    {
        $query_driver = $this->initConnection();

        /**
         * @var $result QueryResult
         */
        $result = $query_driver->fetchAll($q);
        $data = $result->getData();
        $count = $result->countRows();

        $this->assertTrue(is_array($data));
        $this->assertEquals($count, $expected_count);
    }

    /**
     * @param string $q
     * @param int $expected_count
     * @dataProvider getTestData
     */
    public function testCountRows($q, $expected_count)
    {
        $query_driver = $this->initConnection();

        /**
         * @var $result QueryResult
         */
        $result = $query_driver->fetchAll($q);
        $count = $result->countRows();

        $this->assertEquals($count, $expected_count);
    }

    /**
     * @param string $q
     * @param int $expected_count
     * @dataProvider getTestData
     */
    public function testIsSuccess($q, $expected_count)
    {
        $query_driver = $this->initConnection();

        /**
         * @var $result QueryResult
         */
        $result = $query_driver->fetchAll($q);

        $this->assertTrue($result->isSuccess());
        $this->assertTrue(($expected_count > 0));
    }

    public function testGetLastInsertId() {
        $query_driver = $this->initConnection();
        $q = "INSERT INTO `users` VALUES(NULL, ?, ?, ?, NOW())";
        /**
         * @var $result QueryResult
         */
        $result = $query_driver->insert($q, [ 'test', SHA1('abc123'), 'Test User' ]);

        $this->assertTrue(($result->getLastInsertId() > 0));
    }

    public function testGetNumberOfAffectedRows() {
        $query_driver = $this->initConnection();
        $q = "DELETE FROM users WHERE username = ?";
        /**
         * @var $result QueryResult
         */
        $result = $query_driver->delete($q, [ 'test' ]);

        $this->assertTrue(($result->getNumberOfAffectedRows() > 0));
    }

    public function testGetErrorMessage()
    {
        $query_driver = $this->initConnection();

        $q = "SELECT * FROM users WHERE 1";
        /**
         * @var $result QueryResult
         */
        $result = $query_driver->fetchAll($q);

        $this->assertTrue(is_null($result->getErrorMessage()));
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    public function getTestData() {
        return [
            [
                "SELECT * FROM users WHERE 1",
                9
            ],
            [
                "SELECT * FROM users WHERE username = 'camilo'",
                1
            ],
            [
                "SELECT * FROM users WHERE username LIKE 'ben%'",
                2
            ],
            [
                "SELECT * FROM users WHERE username LIKE '%n%'",
                6
            ]
        ];
    }
}