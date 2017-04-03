<?php

namespace App\Model;

final class ArtistModel extends BaseModel
{
    public $tableName = 'artist';

    public function fetchSelectBox()
    {
        return $this->getTable()
            ->select("id, concat_ws(' ', name, middlename, surname) AS name")
            ->where('type', 'artist')
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
