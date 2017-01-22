<?php

namespace App\Model;

final class SeriesModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'ent_series';

    /** @var string */
    protected $ratingTableName = 'rating_series';

    public function getTopFromSeasons($limit)
    {
        return $this
            ->getTable()
            ->group('id')
            ->order("sum(:season:{$this->ratingTableName}.rating)/count(*) DESC")
            ->limit($limit);
    }

    public function getActors($id)
    {
        return $this->query("
        SELECT person.id FROM {$this->tableName}
        LEFT JOIN  ON ent_season.series_id = ent_series.id
        LEFT JOIN jun_season2actor ON jun_season2actor.season_id = ent_season.id
        RIGHT JOIN person on person.id = jun_season2actor.person_id
        WHERE ent_series.id = ?
        GROUP BY person.id", $id);
    }
}
