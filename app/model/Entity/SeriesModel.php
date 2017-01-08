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
            ->order("sum(:series_season:{$this->ratingTableName}.rating)/count(*) DESC")
            ->limit($limit);
    }
}
