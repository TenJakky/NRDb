<?php

namespace App\Model;

final class ArtistModel extends BaseModel
{
    public $tableName = 'artist';

    public function fetchPersonSelectBox()
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
            ->where('type', 'pseudonym')
            ->order('name ASC')
            ->fetchPairs('id', 'name');
    }

    public function fetchGroupSelectBox()
    {
        return $this->getTable()
            ->where('type', 'group')
            ->order('name ASC')
            ->fetchPairs('id', 'name');
    }

    public function fetchSelectBox()
    {
        return $this->getTable()
            ->select("id, concat_ws(' ', name, middlename, surname) AS name")
            ->order('surname ASC')
            ->fetchPairs('id', 'name');
    }
}
