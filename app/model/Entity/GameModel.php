<?php

namespace App\Model;

final class GameModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'game';

    /** @var string */
    protected $ratingTableName = 'rating_game';
}
