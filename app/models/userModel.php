<?php

namespace App\Models;

use Root\Base\BaseModel;
// use Root\Migration\MigrationBP;

class UserModel extends BaseModel
{
    public static $tableName = 'users';
    public static $primaryId = "user_id";

    // public function schemaColumn()
    // {
    //     return [
    //         'column1' => [ MigrationBP::column('column1')->int()->nullable()->unique()],
    //         'column2' => [ MigrationBP::column('column2')->int()->nullable()->index()],
    //         'column3' => [ MigrationBP::column('column3')->int()->nullable()],
    //         'column4' => [ MigrationBP::column('column4')->varchar(30)],
    //         'column5' => [ MigrationBP::column('column5')->varchar(30)->nullable()],
    //     ];
    // }
}
