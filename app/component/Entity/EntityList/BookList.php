<?php

namespace App\Component;

final class BookList extends EntityList
{
    public function __construct(
        \App\Model\BookModel $bookModel,
        \App\Model\RatingBookModel $ratingBookModel)
    {
        parent::__construct();

        $this->model = $bookModel;
        $this->ratingModel = $ratingBookModel;
        $this->artistType = 'author';
        $this->entityType = 'book';
    }
}
