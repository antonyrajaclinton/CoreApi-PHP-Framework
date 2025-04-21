<?php

namespace Root\Base;

  class BaseModel
{
    protected $tableName;
    protected $primaryId = "id";

    public function insert(){

        echo $this->tableName;

    }
}
