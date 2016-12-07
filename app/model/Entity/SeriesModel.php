<?php

namespace App\Model;

final class SeriesModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'series';

    /** @var string */
    protected $ratingTableName = 'rating_series';
}
