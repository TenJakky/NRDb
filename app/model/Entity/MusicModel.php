<?php

namespace App\Model;

final class MusicModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'ent_music';

    /** @var string */
    protected $ratingTableName = 'rating_music';
}
