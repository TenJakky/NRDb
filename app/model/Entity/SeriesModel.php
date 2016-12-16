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
        return $this->query("
        SELECT
        {$this->tableName}.*
        FROM {$this->tableName}
        LEFT JOIN series_season ON {$this->tableName}.id = series_season.{$this->tableName}_id
        LEFT JOIN {$this->ratingTableName} ON series_season.id = {$this->ratingTableName}.series_season_id
        GROUP BY {$this->tableName}.id
        ORDER BY sum({$this->ratingTableName}.rating) / count({$this->ratingTableName}.id) DESC
        LIMIT {$limit}");
    }

    public function getNotRated($userId, $limit = false)
    {
        return $this->getTable()->limit($limit);
    }
}
