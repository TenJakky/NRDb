<?php

namespace App\Model;

class UserModel extends BaseModel
{
    public $tableName = 'user';

    public function getMaxRatings($category)
    {
        return $this->getTable()->select("ratings_$category AS count")->order("ratings_$category DESC")->limit(1)->fetch()->count;
    }
}
