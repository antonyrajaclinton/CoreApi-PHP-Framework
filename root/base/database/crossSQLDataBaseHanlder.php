<?php

namespace Root\Base\Database;

use Root\Init\InitDatabase;


// ['mysql', 'pgsql', 'sqlite']

class CrossSQLDatabaseHandler
{
    private $dbConnection = null;
    private $dbInstanceName = null;
    private $databaseName = null;
    private $databaseDriver = null;
    public function __construct($dbInstanceName = 'default')
    {
        $this->dbInstanceName = $dbInstanceName;
        $getDataBaseConfig = InitDatabase::getDataBaseConfig($this->dbInstanceName);
        $this->databaseName = $getDataBaseConfig['dbname'];
        $this->databaseDriver = $getDataBaseConfig['driver'];
        $this->dbConnection = InitDatabase::getInstance($this->dbInstanceName);
    }

    public function isTableExists($table): bool
    {
        if ($this->databaseDriver == 'sqlite') {
            $sqlQuery = "SELECT EXISTS ( SELECT 1 FROM sqlite_master WHERE type = '{$this->databaseName}' AND name = '{$table}')";
        } else {
            $sqlQuery = "SELECT EXISTS ( SELECT 1 FROM information_schema.tables WHERE table_schema = '{$this->databaseName}' AND table_name = '{$table}' ) AS table_exists ";
        }
        return (!empty($this->dbConnection->query($sqlQuery)->fetchColumn())) ? true : false;
    }
}
