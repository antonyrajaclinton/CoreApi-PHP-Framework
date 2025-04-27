<?php

namespace App\Models;

use Root\Base\BaseModel;
use Root\Migration\MigrationBP;

class UserModel extends BaseModel
{
    public static $tableName = 'users';
    public static $primaryId = "user_id";
    public static $timeStamp = true;

    public function schemaColumn()
    {
        return [
            'userName' => ['name' => 'user_name', 'type' => MigrationBP::dataType()->text()]
        ];
    }
}
