<?php

namespace App\Model;

final class SeasonModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'ent_season';

    /** @var string */
    protected $ratingTableName = 'rating_season';

    public function getNotRated($userId, $limit = null)
    {
        return $this
            ->getTable()
            ->select("{$this->tableName}.*, CONCAT(series.original_title, \" \", number, \".season\") AS original_title")
            ->joinWhere(":{$this->ratingTableName}", ":{$this->ratingTableName}.user_id", $userId)
            ->where(":{$this->ratingTableName}.user_id", null)
            ->order("{$this->tableName}.id DESC")
            ->limit($limit);
    }

    public function getRated($userId, $limit = null)
    {
        return $this
            ->getTable()
            ->select("{$this->tableName}.*, CONCAT(series.original_title, ' ', number, '.season') AS original_title")
            ->joinWhere(":{$this->ratingTableName}", ":{$this->ratingTableName}.user_id", $userId)
            ->where(":{$this->ratingTableName}.user_id", $userId)
            ->order("{$this->tableName}.id DESC")
            ->limit($limit);
    }
}
