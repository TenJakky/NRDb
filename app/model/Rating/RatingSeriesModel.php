<?php

namespace App\Model;

final class RatingSeriesModel extends BaseRatingModel
{
    public $tableName = 'rating_series';

    public function getUserRatingFromSeasons($entityId, $userId)
    {
        return $this->query("
        SELECT
        sum(`season`) / count(*) as `rating`
        FROM (
        SELECT
        sum(rating_series_season.rating) / count(*) as `season`
        FROM rating_series_season
        LEFT JOIN ent_series_season ON rating_series_season.series_season_id = ent_series_season.id
        WHERE ent_series_season.series_id = ? AND rating_series_season.user_id = ?
        GROUP BY ent_series_season.number
        ) AS `subquery`", $entityId, $userId)->fetch()->rating;
    }

    public function getRatingFromSeasons($entityId)
    {
        return $this->query("
        SELECT
        sum(`season`) / count(*) as `rating`
        FROM (
        SELECT
        sum(rating_series_season.rating) / count(*) as `season`
        FROM rating_series_season
        LEFT JOIN ent_series_season ON rating_series_season.series_season_id = ent_series_season.id
        WHERE ent_series_season.series_id = ?
        GROUP BY ent_series_season.number
        ) AS `subquery`", $entityId)->fetch()->rating;
    }
}
