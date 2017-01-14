<?php

namespace App\Model;

final class SeasonModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'ent_season';

    /** @var string */
    protected $ratingTableName = 'rating_season';
}
