<?php

namespace App\Presenter;

class DefaultPresenter extends BasePresenter
{
    protected $movieModel;
    protected $seriesModel;
    protected $bookModel;
    protected $gameModel;

    protected $ratingMovieModel;
    protected $ratingSeriesModel;
    protected $ratingBookModel;
    protected $ratingGameModel;

    protected $changelogModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\SeriesModel $seriesModel,
        \App\Model\BookModel $booksModel,
        \App\Model\GameModel $gamesModel,
        \App\Model\RatingMovieModel $ratingsMovieModel,
        \App\Model\RatingSeriesModel $ratingsSeriesModel,
        \App\Model\RatingBookModel $ratingsBookModel,
        \App\Model\RatingGameModel $ratingsGameModel,
        \App\Model\ChangelogModel $changelogModel
)
    {
        $this->movieModel = $movieModel;
        $this->seriesModel = $seriesModel;
        $this->bookModel = $booksModel;
        $this->gameModel = $gamesModel;
        $this->ratingMovieModel = $ratingsMovieModel;
        $this->ratingSeriesModel = $ratingsSeriesModel;
        $this->ratingBookModel = $ratingsBookModel;
        $this->ratingGameModel = $ratingsGameModel;
        $this->changelogModel = $changelogModel;
    }

    public function renderSettings()
    {
        $this->template->data = $this->user->getIdentity()->data;
    }

    public function actionLogout()
    {
        $this->user->logout();

        $this->flashMessage('Successfully logged out.', 'success');
        $this->redirect('Default:login');
    }

    public function renderDefault()
    {
        $total = 0;
        $total += $this->template->moviesT = $this->movieModel->findAll()->count();
        $total += $this->template->seriesT = $this->seriesModel->findAll()->count();
        $total += $this->template->booksT = $this->bookModel->findAll()->count();
        $total += $this->template->gamesT = $this->gameModel->findAll()->count();
        $this->template->total = $total;

        $totalR = 0;
        $totalR += $this->template->moviesRT = $this->ratingMovieModel->findAll()->count();
        $totalR += $this->template->seriesRT = $this->ratingSeriesModel->findAll()->count();
        $totalR += $this->template->booksRT = $this->ratingBookModel->findAll()->count();
        $totalR += $this->template->gamesRT = $this->ratingGameModel->findAll()->count();
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

        $this->template->changes = $this->changelogModel->findAll()->order('date DESC')->limit(5);
    }
}