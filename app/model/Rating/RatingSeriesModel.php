<?php

namespace App\Model;

final class RatingSeriesModel extends BaseRatingModel
{
    public $tableName = 'rating_series_season';

    public function getUserRating($entityId, $userId)
    {
        return $this->query("
        SELECT
        sum(`season`) / count(*) as `rating`
        FROM (
        SELECT
        sum({$this->tableName}.rating) / count(*) as `season`
        FROM {$this->tableName}
        LEFT JOIN series_season ON {$this->tableName}.series_season_id = series_season.id
        WHERE series_season.series_id = ? AND {$this->tableName}.user_id = ?
        GROUP BY series_season.number
        ) AS `subquery`", $entityId, $userId)->fetch()->rating;
    }

    public function getRating($entityId)
    {
        return $this->query("
        SELECT
        sum(`season`) / count(*) as `rating`
        FROM (
        SELECT
        sum({$this->tableName}.rating) / count(*) as `season`
        FROM {$this->tableName}
        LEFT JOIN series_season ON {$this->tableName}.series_season_id = series_season.id
        WHERE series_season.series_id = ?
        GROUP BY series_season.number
        ) AS `subquery`", $entityId)->fetch()->rating;
    }
}
