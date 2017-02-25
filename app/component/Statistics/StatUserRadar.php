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

        $this->template->statMovie = $this->ratingMovieModel->getUserRatingCount($userId) / $this->ratingMovieModel->getMaxRatingCount();
        $this->template->statSeries = $this->ratingSeriesModel->getUserRatingCount($userId) / $this->ratingSeriesModel->getMaxRatingCount();
        $this->template->statSeason = $this->ratingSeasonModel->getUserRatingCount($userId) / $this->ratingSeasonModel->getMaxRatingCount();
        $this->template->statBook = $this->ratingBookModel->getUserRatingCount($userId) / $this->ratingBookModel->getMaxRatingCount();
        $this->template->statMusic = $this->ratingMusicModel->getUserRatingCount($userId) / $this->ratingMusicModel->getMaxRatingCount();
        $this->template->statGame = $this->ratingGameModel->getUserRatingCount($userId) / $this->ratingGameModel->getMaxRatingCount();

        parent::render();
    }
}
