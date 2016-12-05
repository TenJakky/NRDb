<?php

namespace App\Model;

final class PersonModel extends BaseModel
{
    public $tableName = 'person';

    public function fetchSelectBox()
    {
        $rows = $this->findAll()->order('surname ASC');

        $array = array();
        foreach ($rows as $row)
        {
            $array[$row->id] = $row->name.' '.$row->surname;
        }
        return $array;
    }
}