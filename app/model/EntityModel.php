<?php

namespace App\Model;

class EntityModel extends BaseModel
{
    /** @var  string */
    public $tableName = 'entity';

    public function getRecent()
    {
        return $this->getTable()->order('id DESC');
    }

    public function getTop()
    {
        return $this
            ->getTable()
            ->group('id')
            ->order('rating DESC');
    }

    public function getArtistTop(string $artistType, int $artistId)
    {
        return $this
            ->getTable()
            ->where(':jun_artist2entity.artist_id', $artistId)
            ->where(':jun_artist2entity.role', $artistType)
            ->group('entity.id')
            ->order('rating DESC')
            ->fetch();
    }

    public function getArtistAverage(string $artistType, int $artistId)
    {
        $entity = substr($this->tableName, 4);
        $joinTable = "jun_{$entity}2{$artistType}";

        return $result = $this->query(
        "SELECT
        sum(`subsum`) / count(*) AS `average`
        FROM (
        SELECT 
        (sum({$this->ratingTableName}.rating) / count(*)) AS `subsum`
        FROM {$joinTable}
        LEFT JOIN {$this->ratingTableName} ON {$this->ratingTableName}.{$entity}_id = {$joinTable}.{$entity}_id
        WHERE {$joinTable}.artist_id = ?
        GROUP BY {$this->ratingTableName}.{$entity}_id
        ) AS `subquery`", $artistId)->fetch()->average;
    }

    public function getNotRated($userId)
    {
        return $this
            ->getTable()
            ->joinWhere(':rating', ':rating.user_id', $userId)
            ->where(':rating.user_id', null)
            ->order('entity.id DESC');
    }

    public function getRated($userId, $limit = null)
    {
        return $this
            ->getTable()
            ->joinWhere(':rating', ':rating.user_id', $userId)
            ->where(':rating.user_id', $userId)
            ->order('entity.id DESC')
            ->limit($limit);
    }
}
