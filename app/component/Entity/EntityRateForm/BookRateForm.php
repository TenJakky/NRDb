<?php

namespace App\Component;

final class BookRateForm extends EntityRateForm
{
    public function __construct(
        \App\Model\BookModel $bookModel,
        \App\Model\RatingBookModel $ratingBookModel)
    {
        $this->model= $bookModel;
        $this->ratingModel = $ratingBookModel;
    }
}
