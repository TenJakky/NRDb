<?php

namespace App\Model;

final class MusicModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'music';

    /** @var string */
    protected $ratingTableName = 'rating_music';
}
