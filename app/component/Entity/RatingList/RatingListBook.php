<?php

namespace App\Component;

final class RatingListBook extends RatingList
{
    public function __construct(
        \App\Model\RatingBookModel $ratingBookModel)
    {
        parent::__construct();
        $this->model = $ratingBookModel;
    }
}
