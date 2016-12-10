<?php

namespace App\Model;

final class BandModel extends BaseModel
{
    public $tableName = 'band';

    public function fetchSelectBox()
    {
        return $this->findAll()->order('name ASC')->fetchPairs('id', 'name');
    }
}
