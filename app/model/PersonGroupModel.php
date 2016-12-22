<?php

namespace App\Model;

final class PersonGroupModel extends BaseModel
{
    public $tableName = 'group';

    public function fetchSelectBox()
    {
        return $this->getTable()->order('name ASC')->fetchPairs('id', 'name');
    }
}
