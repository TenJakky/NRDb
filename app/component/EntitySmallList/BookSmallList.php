<?php

namespace App\Component;

final class BookSmallList extends EntitySmallList
{
    public function __construct(
        \App\Model\BookModel $bookModel,
        \App\Model\RatingBookModel $ratingBookModel)
    {
        $this->model = $bookModel;
        $this->ratingModel = $ratingBookModel;
    }
}
