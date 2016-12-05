<?php

namespace App\Presenter;

final class MoviePresenter extends BaseEntityPresenter
{
    protected $model;
    protected $ratingModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        $this->model = $movieModel;
        $this->ratingModel = $ratingMovieModel;
    }
}