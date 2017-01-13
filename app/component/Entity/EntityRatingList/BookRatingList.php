<?php

namespace App\Component;

final class BookRatingList extends EntityRatingList
{
    public function __construct(
        \App\Model\RatingBookModel $ratingBookModel)
    {
        parent::__construct();
        $this->model = $ratingBookModel;
    }
}
