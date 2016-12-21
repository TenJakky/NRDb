<?php

namespace App\Model;

final class MovieModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'ent_movie';

    /** @var string */
    protected $ratingTableName = 'rating_movie';
}
