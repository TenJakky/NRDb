<?php

namespace App\Component;

class StatElementCount extends BaseComponent
{
    protected $movieModel;
    protected $seriesModel;
    protected $seasonModel;
    protected $bookModel;
    protected $musicModel;
    protected $gameModel;

    protected $ratingMovieModel;
    protected $ratingSeriesModel;
    protected $ratingSeasonModel;
    protected $ratingBookModel;
    protected $ratingMusicModel;
    protected $ratingGameModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\SeriesModel $seriesModel,
        \App\Model\SeasonModel $seasonModel,
        \App\Model\BookModel $booksModel,
        \App\Model\MusicModel $musicModel,
        \App\Model\GameModel $gamesModel,
        \App\Model\RatingMovieModel $ratingMovieModel,
        \App\Model\RatingSeriesModel $ratingSeriesModel,
        \App\Model\RatingSeasonModel $ratingSeasonModel,
        \App\Model\RatingBookModel $ratingBookModel,
        \App\Model\RatingMusicModel $ratingMusicModel,
        \App\Model\RatingGameModel $ratingGameModel)
    {
        $this->movieModel = $movieModel;
        $this->seriesModel = $seriesModel;
        $this->seasonModel = $seasonModel;
        $this->bookModel = $booksModel;
        $this->musicModel = $musicModel;
        $this->gameModel = $gamesModel;
        $this->ratingMovieModel = $ratingMovieModel;
        $this->ratingSeriesModel = $ratingSeriesModel;
        $this->ratingSeasonModel = $ratingSeasonModel;
        $this->ratingBookModel = $ratingBookModel;
        $this->ratingMusicModel = $ratingMusicModel;
        $this->ratingGameModel = $ratingGameModel;
    }

    public function render()
    {
        $total = 0;
        $total += $this->template->moviesT = $this->movieModel->count();
        $total += $this->template->seriesT = $this->seriesModel->count();
        $total += $this->template->seasonsT = $this->seasonModel->count();
        $total += $this->template->booksT = $this->bookModel->count();
        $total += $this->template->musicT = $this->musicModel->count();
        $total += $this->template->gamesT = $this->gameModel->count();
        $this->template->total = $total;

        $totalR = 0;
        $totalR += $this->template->moviesRT = $this->ratingMovieModel->count();
        $totalR += $this->template->seriesRT = $this->ratingSeriesModel->count();
        $totalR += $this->template->seasonsRT = $this->ratingSeasonModel->count();
        $totalR += $this->template->booksRT = $this->ratingBookModel->count();
        $totalR += $this->template->musicRT = $this->ratingMusicModel->count();
        $totalR += $this->template->gamesRT = $this->ratingGameModel->count();
        $this->template->totalR = $totalR;

        for ($i = 0; $i <= 10; $i++)
        {
            $count = 0;
            $count += $this->template->{"movies{$i}"} = $this->ratingMovieModel->findBy('rating', $i)->count();
            $count += $this->template->{"series{$i}"} = $this->ratingSeriesModel->findBy('rating', $i)->count();
            $count += $this->template->{"seasons{$i}"} = $this->ratingSeasonModel->findBy('rating', $i)->count();
            $count += $this->template->{"books{$i}"} = $this->ratingBookModel->findBy('rating', $i)->count();
            $count += $this->template->{"music{$i}"} = $this->ratingMusicModel->findBy('rating', $i)->count();
            $count += $this->template->{"games{$i}"} = $this->ratingGameModel->findBy('rating', $i)->count();
            $this->template->{"total{$i}"} = $count;
        }

        parent::render();
    }
}