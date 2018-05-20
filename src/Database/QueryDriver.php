<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 18/03/2018
 * Time: 12:53 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Database;

use Doctrine\DBAL\Connection;

class QueryDriver implements QueryDriverInterface
{
    /**
     * @var Connection
     */
    private $db;



    public function __construct(Connection $db)
    {
        $this->setDb($db);
    }

    /**
     * @return Connection
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param Connection $db
     * @return $this
     */
    public function setDb(Connection $db)
    {
        $this->db = $db;
        return $this;
    }

    /**
     * @param $query_statement
     * @param array $params
     * @return QueryResult
     * @throws \Exception
     */
    public function fetchAll($query_statement, $params = [])
    {
        if (strtoupper(substr($query_statement, 0, 6)) != 'SELECT') {
            throw new \Exception('Error! The SQL statement must be SELECT ...');
        }

        $data = [];
        $row_count = 0;
        $affected_rows = 0;
        $last_insert_id = 0;
        $success = false;
        $error_message = null;

        try {
            $sql = $this->getDb()->prepare($query_statement);
            $success = $sql->execute($params);
            $data = $sql->fetchAll();
            $row_count = $sql->rowCount();
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
        }
        $this->getDb()->close();

        return new QueryResult(
            $data, $success, $row_count, $affected_rows, $last_insert_id, $error_message
        );
    }

    /**
     * @param $query_statement
     * @param array $params
     * @return QueryResult
     * @throws \Exception
     */
    public function fetchRow($query_statement, $params = [])
    {
        if (strtoupper(substr($query_statement, 0, 6)) != 'SELECT') {
            throw new \Exception('Error! The SQL statement must be SELECT ...');
        }

        $data = [];
        $row_count = 0;
        $affected_rows = 0;
        $last_insert_id = 0;
        $success = false;
        $error_message = null;

        try {
            $sql = $this->getDb()->prepare($query_statement);
            $success = $sql->execute($params);
            $data = $sql->fetch();
            $row_count = 1;
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
        }
        $this->getDb()->close();

        return new QueryResult(
            $data, $success, $row_count, $affected_rows, $last_insert_id, $error_message
        );
    }

    /**
     * @param $query_statement
     * @param array $params
     * @return QueryResult
     * @throws \Exception
     */
    public function insert($query_statement, $params = [])
    {
        if (strtoupper(substr($query_statement, 0, 6)) != 'INSERT') {
            throw new \Exception('Error! The SQL statement must be INSERT INTO ...');
        }

        $data = null;
        $row_count = 0;
        $affected_rows = 0;
        $last_insert_id = 0;
        $success = false;
        $error_message = null;

        try {
            $affected_rows = $this->getDb()->executeUpdate($query_statement, $params);
            $success = true;
            $last_insert_id = $this->getDb()->lastInsertId();
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
        }
        $this->getDb()->close();

        return new QueryResult(
            $data, $success, $row_count, $affected_rows, $last_insert_id, $error_message
        );
    }

    /**
     * @param $query_statement
     * @param array $params
     * @return QueryResult
     * @throws \Exception
     */
    public function update($query_statement, $params = [])
    {
        if (strtoupper(substr($query_statement, 0, 6)) != 'UPDATE') {
            throw new \Exception('Error! The SQL statement must be UPDATE ...');
        }

        $data = null;
        $row_count = 0;
        $affected_rows = 0;
        $last_insert_id = 0;
        $success = false;
        $error_message = null;

        try {
            $affected_rows = $this->getDb()->executeUpdate($query_statement, $params);
            $success = true;
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
        }
        $this->getDb()->close();

        return new QueryResult(
            $data, $success, $row_count, $affected_rows, $last_insert_id, $error_message
        );
    }

    /**
     * @param $query_statement
     * @param array $params
     * @return QueryResult
     * @throws \Exception
     */
    public function delete($query_statement, $params = [])
    {
        if (strtoupper(substr($query_statement, 0, 6)) != 'DELETE') {
            throw new \Exception('Error! The SQL statement must be DELETE ...');
        }

        $data = null;
        $row_count = 0;
        $affected_rows = 0;
        $last_insert_id = 0;
        $success = false;
        $error_message = null;

        try {
            $affected_rows = $this->getDb()->executeUpdate($query_statement, $params);
            $success = true;
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
        }
        $this->getDb()->close();

        return new QueryResult(
            $data, $success, $row_count, $affected_rows, $last_insert_id, $error_message
        );
    }
}