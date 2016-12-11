<?php

namespace App\Component;

final class RateFormMovie extends RateForm
{
    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        $this->model= $movieModel;
        $this->ratingModel = $ratingMovieModel;
    }
}
