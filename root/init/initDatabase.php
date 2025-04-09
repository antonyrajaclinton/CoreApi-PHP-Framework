<?php
namespace Root\Init;

require_once APP_PATH . '/app/config/dataBaseConfig.php';

use PDO;
use Exception;
$GLOBALS['dataBaseConfig'] = $dataBaseConfig;
class InitDatabase
{
    static $dbConnection = null;
    private static function pdoConnect()
    {
        foreach ($GLOBALS['dataBaseConfig'] as $dbKey => $dbValue) {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            if (in_array($dbValue['driver'], ['mysql', 'pgsql', 'sqlite'])) {
                if (!empty($dbValue['persistent']) && $dbValue['persistent'] == true) {
                    $options[PDO::ATTR_PERSISTENT] = true;
                }
                if (!empty($dbValue['charset']) && !empty($dbValue['collation'])) {
                    $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES '{$dbValue['charset']}' COLLATE '{$dbValue['collation']}'";
                }
                if (in_array($dbValue['driver'], ['mysql', 'pgsql'])) {
                    self::$dbConnection[$dbKey] = new PDO("{$dbValue['driver']}:host={$dbValue['host']};port={$dbValue['port']};dbname={$dbValue['dbname']}", $dbValue['username'], $dbValue['password'], $options);
                } else if ($dbValue['driver'] == 'sqlite') {
                    self::$dbConnection[$dbKey] = new PDO("{$dbValue['driver']}:{$dbValue['path']}", null, null, $options);
                }
                if (!empty($dbValue['rollback'])) {
                    self::$dbConnection[$dbKey]->beginTransaction();
                }
            } else {
                throw new Exception("Database driver not supported: {$dbValue['driver']}");
            }
        }
    }
    public static function getInstance($dbName = 'default')
    {
        if (!isset(self::$dbConnection[$dbName])) {
            self::pdoConnect();
        }
        return self::$dbConnection[$dbName];
    }
}



// // $getClass = new InitDB();

// // $getClass->pdoConnect();




// $connection = DB::getInstance('sqlite');
// // $connection = $db->getConnection();


// // Example database operations



// // $connection->query("INSERT INTO users (user_name, user_email, user_password) VALUES ('1', ':email', ':password')");
// $getId = $connection->query("CREATE TABLE `users` (
//   `user_name` varchar(255) NOT NULL,
//   `user_email` varchar(255) NOT NULL,
//   `user_password` text NOT NULL
// )");

// $getId = $connection->query("INSERT INTO users (user_name, user_email, user_password) VALUES ('sdf2sdf', ':email', ':password')");
// echo $connection->lastInsertId();


// // $connection->commit();
// // $connection->rollBack();


// // $connection = DB::getInstance();


// // // Example database operations
// // // exit;

// // // $connection->beginTransaction();
// // $connection->query("INSERT INTO users (user_name, user_email, user_password) VALUES ('2', ':email', ':password')");
// // $connection->query("INSERT INTO users (user_name, user_email, user_password) VALUES ('sdf3sdf', ':email', ':password')");

// // // $connection->rollBack();
// // // exit;
// // $connection->commit();
