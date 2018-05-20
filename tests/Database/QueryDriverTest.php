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

use PHPUnit\Framework\TestCase;
use camilord\utilus\Database\QueryDriver;
use Doctrine\DBAL\Driver\Mysqli\Driver;
use Doctrine\DBAL\Connection;

class QueryDriverTest extends TestCase
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
     * @dataProvider getTestDataFetchAll
     */
    public function testFetchAll($q, $expected_count)
    {
        $query_driver = $this->initConnection();
        $result = $query_driver->fetchAll($q);
        $data = $result->getData();
        $count = $result->countRows();

        $this->assertEquals($count, $expected_count);
        $this->assertTrue(is_array($data));
        $this->assertEquals($count, count($data));
    }

    /**
     * @param string $q
     * @param int $expected_count
     * @dataProvider getTestDataFetchRow
     */
    public function testFetchRow($q, $expected_count) {
        $query_driver = $this->initConnection();
        $result = $query_driver->fetchRow($q);
        $data = $result->getData();
        $count = $result->countRows();

        $this->assertEquals($count, $expected_count);
        $this->assertTrue(is_array($data));
    }

    public function testInsert() {
        $query_driver = $this->initConnection();
        $q = "INSERT INTO `users` VALUES(NULL, ?, ?, ?, NOW())";
        $result = $query_driver->insert($q, [ 'test', SHA1('abc123'), 'Test User' ]);

        $this->assertTrue($result->isSuccess());
        $this->assertTrue(($result->getLastInsertId() > 0));
    }

    public function testUpdate() {
        $query_driver = $this->initConnection();
        $q = "UPDATE users SET username = ? WHERE username = ?";
        $result = $query_driver->update($q, [ 'tester', 'test' ]);

        $this->assertTrue($result->isSuccess());
        $this->assertTrue(($result->getNumberOfAffectedRows() > 0));
    }

    public function testDelete() {
        $query_driver = $this->initConnection();
        $q = "DELETE FROM users WHERE username = ?";
        $result = $query_driver->delete($q, [ 'tester' ]);

        $this->assertTrue($result->isSuccess());
        $this->assertTrue(($result->getNumberOfAffectedRows() > 0));
    }

    /*
     * ==== DATA PROVIDERS =============================================================================================
     */

    public function getTestDataFetchAll() {
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

    public function getTestDataFetchRow() {
        return [
            [
                "SELECT * FROM users WHERE 1",
                1
            ],
            [
                "SELECT * FROM users WHERE username = 'camilo'",
                1
            ],
            [
                "SELECT * FROM users WHERE username LIKE 'ben%'",
                1
            ],
            [
                "SELECT * FROM users WHERE username LIKE '%n%'",
                1
            ]
        ];
    }
}