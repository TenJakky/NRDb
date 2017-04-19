<?php

namespace App\Model;

final class EntityModel extends BaseModel
{
    /** @var  string */
    public $tableName = 'entity';

    public function getRecent()
    {
        return $this->getTable()->order('id DESC');
    }

    public function getSmallListRecent($userId)
    {
        return $this->getRecent()
            ->alias(':rating', 'r')
            ->select('entity.*, r.value AS my_rating, r.id AS my_rating_id')
            ->joinWhere('r', 'r.user_id', $userId);
    }

    public function getTop()
    {
        return $this->getTable()->order('rating DESC');
    }

    public function getSmallListTop($userId)
    {
        return $this->getTop()
            ->alias(':rating', 'r')
            ->select('entity.*, r.value AS my_rating, r.id AS my_rating_id')
            ->joinWhere('r', 'r.user_id', $userId);
    }

    public function getRated($userId)
    {
        return $this->getTable()
            ->alias(':rating', 'r')
            ->joinWhere('r', 'r.user_id', $userId)
            ->where('r.user_id', $userId)
            ->order('entity.id DESC');
    }

    public function getNotRated($userId)
    {
        return $this->getTable()
            ->alias(':rating', 'r')
            ->joinWhere('r', 'r.user_id', $userId)
            ->where('r.user_id', null)
            ->order('entity.id DESC');
    }

    public function getSmallListNotRated($userId)
    {
        return $this->getNotRated($userId)->select('entity.*, r.value AS my_rating, r.id AS my_rating_id');
    }

    public function fetchSeriesSelectBox()
    {
        return $this
            ->getTable()
            ->where('type', 'series')
            ->fetchPairs('id', 'original_title');
    }
}
