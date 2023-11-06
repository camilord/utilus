<?php
/**
 * ----------------------------------------------------
 * Created by: PhpStorm.
 * Written by: Camilo Lozano III (Camilo3rd)
 *             www.camilord.com
 *             me@camilord.com
 * Date: 15/06/2018
 * Time: 12:22 AM
 * ----------------------------------------------------
 */

namespace camilord\utilus\Database;

/**
 * Class xSQL
 * @package camilord\utilus\Database
 */
class xSQL {

    /**
     * @var \PDO
     */
    protected $_db;
    /**
     * @var \PDOStatement
     */
    protected $_statement;

    /**
     * @var bool|mixed
     */
    private $is_success;

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'test';
    private $charset = 'utf8';
    private $driver = 'mysql';
    private $port = 3306;

    /**
     * xSQL constructor.
     * @param null $params
     * @param bool $auto_connect
     */
    public function __construct($params = null, $auto_connect = true) {
        if ($auto_connect === true) {
            $this->connect($params);
        } else {
            $this->populate_params($params ?? []);
        }
    }

    /**
     * @param array $params
     */
    private function populate_params(array $params) {
        if (is_array($params) && count($params) > 0) {
            foreach ($params as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }

    /**
     * @param null|array $params
     * @param bool $auto_connect
     */
    public function connect($params = null)
    {
        if (is_null($params)) {
            $params = [];
        }
        $this->populate_params($params);

        $this->_db = new \PDO($this->driver.':host='.$this->host.';port='.$this->port.';dbname='.$this->database.';charset='.$this->charset, $this->username, $this->password);
        if (!$this->_db) {
            echo "\n\n".'Unable to connect to the Database!'."\n\n";
            die();
        }
    }

    /**
     * @param string $connection
     * @param string $username
     * @param string $password
     * @param bool $auto_connect
     */
    public function connect_override($connection, $username, $password)
    {
        $this->_db = new \PDO($connection, $username, $password);
        if (!$this->_db) {
            echo "\n\n".'Unable to connect to the Database!'."\n\n";
            die();
        }
    }

    /**
     * @return bool
     */
    public function is_connected() {
        return (is_object($this->_db) && $this->_db instanceof \PDO);
    }

    /**
     * @param $statement
     * @param $params
     * @return mixed
     */
    public function query($statement, $params) {
        //return $this->_statement = $this->_db->query($statement, $params);
        $this->_statement = $this->_db->prepare($statement);
        $this->is_success = $this->_statement->execute($params);
        return $this->is_success;
    }

    /**
     * @return bool|mixed
     */
    public function success() {
        return $this->is_success;
    }

    /**
     * @return array
     */
    public function error_message() {
        return $this->_db->errorInfo();
    }

    /**
     * @return int
     */
    public function affected_rows() {
        return $this->num_rows();
    }

    /**
     * get number of rows from the query
     * @return int
     */
    public function num_rows() {
        return $this->_statement->rowCount();
    }

    /**
     * @return bool
     */
    public function exists() {
        return ($this->num_rows() > 0);
    }

    /**
     * fetch mixed associative array and numeric array
     * @return mixed
     */
    public function fetch() {
        return $this->_statement->fetch();
    }

    /**
     * get associative array
     * @return mixed
     */
    public function fetch_assoc() {
        return $this->_statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * fetch all mixed associative array and numeric array
     * @return mixed
     */
    public function fetch_all() {
        return $this->_statement->fetchAll();
    }

    /**
     * fetch all mixed associative array
     * @return mixed
     */
    public function fetch_all_assoc() {
        return $this->_statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * insert a row to the table
     * @param $statement
     * @param $params
     * @return mixed
     */
    public function insert($statement, $params) {
        return $this->query($statement, $params);
    }

    /**
     * update row to a table
     * @param $statement
     * @param $params
     * @return mixed
     */
    public function update($statement, $params) {
        return $this->query($statement, $params);
    }

    /**
     * get last mysql id
     * @return mixed
     */
    public function last_id() {
        return $this->_db->lastInsertId();
    }
}
