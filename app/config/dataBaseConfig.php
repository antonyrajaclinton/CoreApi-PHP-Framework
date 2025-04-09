<?php

$dataBaseConfig['default'] = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'testdb',
    'username' => 'root',
    'password' => '',
    'persistent' => true,
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'rollback' => true,
];

$dataBaseConfig['sqlite'] = [
    'driver' => 'sqlite',
    'path' => APP_PATH . '/database/db.sqlite'
];
