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
        if ($this->ratingMovieModel->findByArray(array(
            'user_id' => $this->getUser()->getId(),
            'movie_id' => $id
            ))->count('*') > 0)
        {
            $this->presenter->flashMessage('You have already rated this movie.', 'failure');
            $this->presenter->redirect('Movie:view', $id);
        }

        $this->template->id = $id;
    }

    public function actionEditRating($id)
    {
        $this->template->ratingId = $id;
    }

    public function actionEdit($id)
    {
        $this->template->id = $id;
    }
}