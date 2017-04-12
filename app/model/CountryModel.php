<?php

namespace App\Model;

final class CountryModel extends BaseModel
{
    public $tableName = 'def_country';

    public function fetchSelectBox()
    {
        return $this->getTable()->fetchPairs('id', 'name');
    }
}
