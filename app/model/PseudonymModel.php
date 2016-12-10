<?php

namespace App\Model;

final class PseudonymModel extends BaseModel
{
    public $tableName = 'pseudonym';

    public function fetchSelectBox()
    {
        return $this->findAll()->order('name ASC')->fetchPairs('id', 'name');
    }
}
