<?php

namespace App\Presenter;

class MoviePresenter extends BaseViewPresenter
{
    protected $model;
    protected $ratingMovieModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel
    )
    {
        $this->model = $movieModel;
        $this->ratingMovieModel = $ratingMovieModel;
    }

    public function actionView($id)
    {
        parent::actionView($id);

        $this->template->ratingModel = $this->ratingMovieModel;
    }

    public function actionRate($id = 0)
    {
        $this->template->movieId = $id;
    }

    public function actionEditRating($ratingId)
    {
        $this->template->ratingId = $ratingId;
    }

    public function actionEdit($id)
    {
        $this->template->id = $id;
    }
}