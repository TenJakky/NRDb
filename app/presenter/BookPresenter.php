<?php

namespace App\Presenter;

final class BookPresenter extends BaseEntityPresenter
{
    protected $model;
    protected $ratingModel;

    public function __construct(
        \App\Model\BookModel $bookModel,
        \App\Model\RatingBookModel $ratingBookModel)
    {
        $this->model = $bookModel;
        $this->ratingModel = $ratingBookModel;
    }
}
