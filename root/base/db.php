<?php

namespace Root\Base;

use Root\Init\InitDatabase;
use \Exception;


class DB
{
    private $dbConnection = null;
    private $tableName = null;
    private $lastQuery = null;

    public function __construct($dbInstanceName = 'default')
    {
        $this->dbConnection = InitDatabase::getInstance($dbInstanceName);
    }
    public function table(string $tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }
    private function storeQuery(string $query): string
    {
        $GLOBALS['lastQuery'] = $this->lastQuery = $query;
        return $query;
    }

    public function insert($data)
    {
        if ($this->tableName == null) {
            throw new Exception("Table name not set. Use table() method to set the table name.");
        }
        if (empty($data) || !is_array($data)) {
            throw new Exception("Invalid data provided for insert operation.");
        }
        if (count($data) == 0) {
            throw new Exception("No data provided for insert operation.");
        }
        $columns = implode(",", array_keys($data));
        $dataBValues = [];
        foreach (array_values($data) as $value) {
            if (is_string($value)) {
                if (strpos($value, '`') === false) {
                    $value = str_replace('"', "", $value);
                }
                $dataBValues[] =  '"' . $value . '"';
            } else {
                $dataBValues[] =  $value;
            }
        }
        $this->storeQuery("INSERT INTO {$this->tableName} ($columns) VALUES (" . implode(",", $dataBValues) . ")");
        $this->dbConnection->query($this->lastQuery);
        return $this->dbConnection->lastInsertId();
    }
    public static function lastQuery()
    {
        return (isset($GLOBALS['lastQuery'])) ? $GLOBALS['lastQuery'] : null;
    }
    public static function commit($dbName = 'default')  //for rollback
    {
        return InitDatabase::commit($dbName);
    }
}
