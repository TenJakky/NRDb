<?php

namespace App\Model;

final class PersonModel extends BaseModel
{
    public $tableName = 'person';

    public function fetchSelectBox()
    {
        return $this->getTable()
            ->select("id, concat_ws(' ', name, middlename, surname) AS name")
            ->where('type', 'person')
            ->order('surname ASC')
            ->fetchPairs('id', 'name');
    }

    public function fetchPseudonymSelectBox()
    {
        return $this->getTable()
            ->select("id, concat_ws(' ', name, middlename, surname) AS name")
            ->where('type', 'pseudonym')
            ->order('surname ASC')
            ->fetchPairs('id', 'name');
    }

    public function fetchAllSelectBox()
    {
        return $this->getTable()
            ->select("id, concat_ws(' ', name, middlename, surname) AS name")
            ->order('surname ASC')
            ->fetchPairs('id', 'name');
    }
}
