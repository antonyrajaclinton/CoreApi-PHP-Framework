<?php

namespace Root\Base;

use Root\Init\InitDatabase;
use \Exception;


class DB
{
    protected $dbConnection = null;
    protected $tableName = null;
    protected $primaryKey = 'id';
    protected $lastQuery = null;

    public function __construct($dbInstanceName = 'default')
    {
        $this->dbConnection = InitDatabase::getInstance($dbInstanceName);
    }
    public function table($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }
    public function lastQuery()
    {
        return $this->lastQuery;
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
        $this->lastQuery = "INSERT INTO {$this->tableName} ($columns) VALUES (" . implode(",", $dataBValues) . ")";
        $this->dbConnection->query($this->lastQuery);
        return $this->dbConnection->lastInsertId();
    }
}


// $getInstance = new DB();

// $getInstance->table('users')->insert(['user_name' => "adsddfasd`dd",'user_email'=>'hello']);

// InitDatabase::getInstance('default')->commit();
