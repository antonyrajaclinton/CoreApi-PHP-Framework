<?php


class InitDB
{

    private $dbName = 'default';

    public function __construct($getDBConfigName = 'default')
    {
        $this->dbName = $getDBConfigName;
    }

    public function initPDO()
    {
        
            $dbh = new PDO('mysql:host=localhost;dbname=tesdt', 'root','');
        

    }
}



$getClass=new InitDB();

$getClass->initPDO();