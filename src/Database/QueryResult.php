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


class QueryResult
{
    private $data;
    private $is_success;
    private $count_rows;
    private $affected_rows;
    private $last_insert_id;
    private $error_message;

    public function __construct($data, $success, $count = 0, $affected_rows = 0, $last_insert_id = null, $error_message = '')
    {
        $this->data = $data;
        $this->is_success = $success;
        $this->count_rows = $count;
        $this->affected_rows = $affected_rows;
        $this->last_insert_id = $last_insert_id;
        $this->error_message = $error_message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function isSuccess()
    {
        return $this->is_success;
    }

    /**
     * @return mixed
     */
    public function countRows()
    {
        return $this->count_rows;
    }

    /**
     * @return mixed
     */
    public function getNumberOfAffectedRows()
    {
        return $this->affected_rows;
    }

    /**
     * @return mixed
     */
    public function getLastInsertId()
    {
        return $this->last_insert_id;
    }

    /**
     * @return string
     */
    public function getErrorMessage() {
        return $this->error_message;
    }
}