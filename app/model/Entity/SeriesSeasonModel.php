<?php

namespace App\Model;

final class SeriesSeasonModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'ent_series_season';

    /** @var string */
    protected $ratingTableName = 'rating_series_season';
}
