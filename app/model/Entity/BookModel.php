<?php

namespace App\Model;

final class BookModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'ent_book';

    /** @var string */
    protected $ratingTableName = 'rating_book';
}
