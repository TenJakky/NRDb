<?php

namespace App\Model;

final class SeriesModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'series';

    /** @var string */
    protected $ratingTableName = 'rating_series_season';

    public function getTop($limit)
    {
        return $this
            ->findAll()
            ->group('id')
            ->order("sum(:series_season:{$this->ratingTableName}.rating)/count(*) DESC")
            ->limit($limit);
    }

    public function getNotRated($userId, $limit = false)
    {
        return $this
            ->findAll()
            ->joinWhere(":series_season:{$this->ratingTableName}", 'user_id', $userId)
            ->where(":series_season:{$this->ratingTableName}.user_id", null)
            ->group(':series_season.series_id')
            ->order("{$this->tableName}.id DESC")
            ->limit($limit);
    }
}
