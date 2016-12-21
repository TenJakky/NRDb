<?php

namespace App\Model;

final class GameModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'ent_game';

    /** @var string */
    protected $ratingTableName = 'rating_game';
}
