<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 18/03/2018
 * Time: 12:56 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Database;


use Doctrine\DBAL\Connection;

/**
 * Interface QueryDriverInterface
 * @package camilord\utilus\Database
 */
interface QueryDriverInterface
{
    /**
     * @return Connection
     */
    public function getDB();

    /**
     * @param $db Connection
     * @return mixed|$this
     */
    public function setDB(Connection $db);

    /**
     * @param $sql_statement
     * @param $params array
     * @return mixed
     */
    public function fetchAll($sql_statement, $params = []);

    /**
     * @param $sql_statement
     * @param array $params
     * @return mixed
     */
    public function fetchRow($sql_statement, $params = []);

    /**
     * @param $sql_statement
     * @param array $params
     * @return mixed
     */
    public function insert($sql_statement, $params = []);

    /**
     * @param $sql_statement
     * @param array $params
     * @return mixed
     */
    public function update($sql_statement, $params = []);
}