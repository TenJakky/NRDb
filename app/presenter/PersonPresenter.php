<?php

namespace App\Presenter;

class PersonPresenter extends BaseViewPresenter
{
    protected $model;
    protected $movieModel;
    protected $ratingMovieModel;

    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel
    )
    {
        parent::__construct();
        $this->model = $personModel;
        $this->movieModel = $movieModel;
        $this->ratingMovieModel = $ratingMovieModel;
    }

    public function actionView($id)
    {
        parent::actionView($id);

        $this->template->movies = $this->movieModel->findBy('director_id', $id)->fetchAll();
        $this->template->ratingMovieModel = $this->ratingMovieModel;
    }

    public function actionEdit($id)
    {
        $this->template->id = $id;
    }
}