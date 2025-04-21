<?php

namespace App\Models;

use Root\Base\BaseModel;

class UserModel extends BaseModel
{
    public $tableName = 'users';
    public $primaryId = "user_id";
}

$test = new UserModel();
$test->insert();
