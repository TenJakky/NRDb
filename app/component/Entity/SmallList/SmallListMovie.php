<?php

namespace App\Component;

final class SmallListMovie extends SmallList
{
    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        $this->model = $movieModel;
        $this->ratingModel = $ratingMovieModel;
    }
}
