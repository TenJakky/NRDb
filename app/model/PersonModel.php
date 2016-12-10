<?php

namespace App\Model;

final class PersonModel extends BaseModel
{
    public $tableName = 'person';

    public function fetchSelectBox()
    {
        return $this->getTable()->select("id, concat(name, ' ', surname) AS name")->order('surname ASC')->fetchPairs('id', 'name');
    }
}
