<?php

namespace App\Presenter;

class UserPresenter extends BaseViewPresenter
{
    protected $model;
    protected $ratingMovieModel;

    public function __construct(
        \App\Model\Authenticator $userModel,
        \App\Model\RatingMovieModel $ratingMovieModel
    )
    {
        $this->model = $userModel;
        $this->ratingMovieModel = $ratingMovieModel;
    }

    public function actionView($id)
    {
        parent::actionView($id);

        $this->template->ratingsMovie = $this->ratingMovieModel->findby('user_id', $id)->fetchAll();
    }
}