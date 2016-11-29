<?php
namespace App\Model;

class DirectorModel extends BaseModel
{
    protected $tableName = 'director';

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