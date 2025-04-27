<?php

namespace Root\Base;

use Root\Base\DB;

abstract class BaseModel
{
  protected static $tableName = null;
  protected static $primaryId = "id";
  protected static $timeStamp = false;


   

  public static function create(array $fields = [])
  {
    $getInstance = new DB();
    return $getInstance->table(static::$tableName)->insert($fields);
  }
  public static function commit(string $dbInstanceName = 'default')
  {
    return DB::commit($dbInstanceName);
  }

   
}
