<?php

namespace App\Component;

class StatUserRadar extends BaseComponent
{
    /** @var \App\Model\RatingMovieModel */
    protected $ratingMovieModel;

    /** @var \App\Model\RatingSeriesModel */
    protected $ratingSeriesModel;

    /** @var \App\Model\RatingSeasonModel */
    protected $ratingSeasonModel;

    /** @var \App\Model\RatingBookModel */
    protected $ratingBookModel;

    /** @var \App\Model\RatingMusicModel */
    protected $ratingMusicModel;

    /** @var \App\Model\RatingGameModel */
    protected $ratingGameModel;


    public function __construct(
        \App\Model\RatingMovieModel $ratingMovieModel,
        \App\Model\RatingSeriesModel $ratingSeriesModel,
        \App\Model\RatingSeasonModel $ratingSeasonModel,
        \App\Model\RatingBookModel $ratingBookModel,
        \App\Model\RatingMusicModel $ratingMusicModel,
        \App\Model\RatingGameModel $ratingGameModel)
    {
        $this->ratingMovieModel = $ratingMovieModel;
        $this->ratingSeriesModel = $ratingSeriesModel;
        $this->ratingSeasonModel = $ratingSeasonModel;
        $this->ratingBookModel = $ratingBookModel;
        $this->ratingMusicModel = $ratingMusicModel;
        $this->ratingGameModel = $ratingGameModel;
    }

    public function render()
    {
        $userId = $this->presenter->getParameter('id');

        $this->template->statMovie = $this->ratingMovieModel->getUserRatingCount($userId);
        $this->template->statSeries = $this->ratingSeriesModel->getUserRatingCount($userId);
        $this->template->statSeason = $this->ratingSeasonModel->getUserRatingCount($userId);
        $this->template->statBook = $this->ratingBookModel->getUserRatingCount($userId);
        $this->template->statMusic = $this->ratingMusicModel->getUserRatingCount($userId);
        $this->template->statGame = $this->ratingGameModel->getUserRatingCount($userId);
        $this->template->percentMovie = $this->template->statMovie  / $this->ratingMovieModel->getMaxRatingCount();
        $this->template->percentSeries = $this->template->statSeries  / $this->ratingSeriesModel->getMaxRatingCount();
        $this->template->percentSeason = $this->template->statSeason  / $this->ratingSeasonModel->getMaxRatingCount();
        $this->template->percentBook = $this->template->statBook  / $this->ratingBookModel->getMaxRatingCount();
        $this->template->percentMusic = $this->template->statMusic  / $this->ratingMusicModel->getMaxRatingCount();
        $this->template->percentGame = $this->template->statGame / $this->ratingGameModel->getMaxRatingCount();

        parent::render();
    }
}
