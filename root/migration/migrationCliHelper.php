<?php

namespace Root\Migration;



require_once APP_PATH . '/root/init/initDatabase.php';
require_once APP_PATH . '/root/migration/migrationSchema.php';
require_once APP_PATH . '/root/base/db.php';
require_once APP_PATH . '/root/base/database/crossSQLDataBaseHanlder.php';


$migrationFiles = glob(APP_PATH . '/app/migrations/*.php');


foreach ($migrationFiles as $file) {
    echo $file . "\n";
    require_once $file;
}

use App\Migrations\createMigrations;
use Root\Base\Database\CrossSQLDatabaseHandler;

class MigrationCliHelper
{


    public static function initMigration()
    {
        $MySqlDatabaseClass = new CrossSQLDatabaseHandler();

        //create tables;
        $getCreateMigrations = get_class_methods(new createMigrations());
        foreach ($getCreateMigrations as $method_name) {
            if ($method_name != "__construct") {


                $MySqlDatabaseClass->isTableExists('users');
                echo "$method_name\n";
            }
        }
    }

    public static function createTable($methodName){


        call_user_func([createMigrations::class,'isTableExists'],['users']);

    }
}
