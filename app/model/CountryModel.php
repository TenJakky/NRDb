<?php

namespace App\Model;

final class CountryModel extends \Peldax\NetteInit\Model\BaseModel
{
    public $tableName = 'def_country';

    public function fetchSelectBox()
    {
        return $this->getTable()->fetchPairs('id', 'name');
    }
}
