<?php

namespace App\Migrations;


class createMigrations
{
    public $dbInstance = 'default';

    public function createUserTable()
    {
        $table = 'users';
        $columns = [
            ['column' => 'user_id', 'primary' => true, 'autoIncrement' => true, 'null' => false],
            ['column' => 'user_name', 'null' => false],
            ['column' => 'user_email_address', 'unique' => true, 'dataType' => 'VARCHAR', 'length' => 255, 'index' => true],
            ['column' => 'user_password', 'dataType' => 'TEXT'],
            ['column' => 'created_at', 'dataType' => 'DATETIME', 'null' => true],
            ['column' => 'updated_at', 'dataType' => 'DATETIME', 'null' => true]
        ];
        return ['table' => $table, 'columns' => $columns, 'dbInstance' => $this->dbInstance];
    }
    public function createUserTable1()
    {
        $table = 'userss';
        $columns = [
            ['column' => 'user_id', 'primary' => true, 'autoIncrement' => true, 'null' => false],
            ['column' => 'user_name', 'null' => false],
            ['column' => 'user_email_address', 'unique' => true, 'dataType' => 'VARCHAR', 'length' => 255, 'index' => true],
            ['column' => 'user_password', 'dataType' => 'TEXT'],
            ['column' => 'created_at', 'dataType' => 'DATETIME', 'null' => true],
            ['column' => 'updated_at', 'dataType' => 'DATETIME', 'null' => true]
        ];
        return ['table' => $table, 'columns' => $columns, 'dbInstance' => $this->dbInstance];
    }
}
