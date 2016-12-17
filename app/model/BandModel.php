<?php

namespace App\Model;

final class BandModel extends BaseModel
{
    public $tableName = 'band';

    public function fetchSelectBox()
    {
        return $this->getTable()->order('name ASC')->fetchPairs('id', 'name');
    }
}
