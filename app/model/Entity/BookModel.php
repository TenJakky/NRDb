<?php

namespace App\Model;

final class BookModel extends BaseEntityModel
{
    /** @var string */
    public $tableName = 'book';

    /** @var string */
    protected $ratingTableName = 'rating_book';
}
