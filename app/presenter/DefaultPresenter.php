<?php

namespace App\Presenter;

use App\Model\UserModel;

final class DefaultPresenter extends BasePresenter
{
    protected $movieModel;
    protected $seriesModel;
    protected $bookModel;
    protected $gameModel;

    protected $ratingMovieModel;
    protected $ratingSeriesModel;
    protected $ratingBookModel;
    protected $ratingGameModel;

    protected $userModel;
    protected $introductionModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\SeriesModel $seriesModel,
        \App\Model\BookModel $booksModel,
        \App\Model\GameModel $gamesModel,
        \App\Model\RatingMovieModel $ratingsMovieModel,
        \App\Model\RatingSeriesModel $ratingsSeriesModel,
        \App\Model\RatingBookModel $ratingsBookModel,
        \App\Model\RatingGameModel $ratingsGameModel,
        \App\Model\UserModel $userModel,
        \App\Model\IntroductionModel $introductionModel)
    {
        $this->movieModel = $movieModel;
        $this->seriesModel = $seriesModel;
        $this->bookModel = $booksModel;
        $this->gameModel = $gamesModel;
        $this->ratingMovieModel = $ratingsMovieModel;
        $this->ratingSeriesModel = $ratingsSeriesModel;
        $this->ratingBookModel = $ratingsBookModel;
        $this->ratingGameModel = $ratingsGameModel;
        $this->userModel = $userModel;
        $this->introductionModel = $introductionModel;
    }

    public function actionLogout()
    {
        $this->user->logout();

        $this->flashMessage('Successfully logged out.', 'success');
        $this->redirect('Default:login');
    }

    public function renderDefault()
    {
        $this->template->introduction = $this->introductionModel->getIntroduction();

        $total = 0;
        $total += $this->template->moviesT = $this->movieModel->count();
        $total += $this->template->seriesT = $this->seriesModel->count();
        $total += $this->template->booksT = $this->bookModel->count();
        $total += $this->template->gamesT = $this->gameModel->count();
        $this->template->total = $total;

        $totalR = 0;
        $totalR += $this->template->moviesRT = $this->ratingMovieModel->count();
        $totalR += $this->template->seriesRT = $this->ratingSeriesModel->count();
        $totalR += $this->template->booksRT = $this->ratingBookModel->count();
        $totalR += $this->template->gamesRT = $this->ratingGameModel->count();
        $this->template->totalR = $totalR;

        for ($i = 0; $i <= 10; $i++)
        {
            $count = 0;
            $count += $this->template->{"movies{$i}"} = $this->ratingMovieModel->findBy('rating', $i)->count();
            $count += $this->template->{"series{$i}"} = $this->ratingSeriesModel->findBy('rating', $i)->count();
            $count += $this->template->{"books{$i}"} = $this->ratingBookModel->findBy('rating', $i)->count();
            $count += $this->template->{"games{$i}"} = $this->ratingGameModel->findBy('rating', $i)->count();
            $this->template->{"total{$i}"} = $count;
        }

        $this->template->activeUsers = $this->userModel->getActivity();
    }
}