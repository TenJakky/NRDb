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
        sum(rating_season.rating) / count(*) as `season`
        FROM rating_season
        LEFT JOIN ent_season ON rating_season.season_id = ent_season.id
        WHERE ent_season.series_id = ? AND rating_season.user_id = ?
        GROUP BY ent_season.number
        ) AS `subquery`", $entityId, $userId)->fetch()->rating;
    }

    public function getRatingFromSeasons($entityId)
    {
        return $this->query("
        SELECT
        sum(`season`) / count(*) as `rating`
        FROM (
        SELECT
        sum(rating_season.rating) / count(*) as `season`
        FROM rating_season
        LEFT JOIN ent_season ON rating_season.season_id = ent_season.id
        WHERE ent_season.series_id = ?
        GROUP BY ent_season.number
        ) AS `subquery`", $entityId)->fetch()->rating;
    }
}
