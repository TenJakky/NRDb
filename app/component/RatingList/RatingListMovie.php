<?php

namespace App\Component;

final class RatingListMovie extends RatingList
{
    public function __construct(
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        parent::__construct();
        $this->model = $ratingMovieModel;
    }
}
