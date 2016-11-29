<?php

namespace App\Presenter;

class DirectorPresenter extends BaseViewPresenter
{
    protected $model;
    protected $movieModel;
    protected $ratingMovieModel;

    public function __construct(
        \App\Model\DirectorModel $directorModel,
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel
    )
    {
        parent::__construct();
        $this->model = $directorModel;
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