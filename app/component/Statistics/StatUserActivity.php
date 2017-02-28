<?php

namespace App\Component;

use App\Model\UserModel;

class StatUserActivity extends BaseComponent
{
    /** @var \App\Model\UserModel */
	protected $userModel;

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
        \App\Model\UserModel $userModel,
        \App\Model\RatingMovieModel $ratingMovieModel,
        \App\Model\RatingSeriesModel $ratingSeriesModel,
        \App\Model\RatingSeasonModel $ratingSeasonModel,
        \App\Model\RatingBookModel $ratingBookModel,
        \App\Model\RatingMusicModel $ratingMusicModel,
        \App\Model\RatingGameModel $ratingGameModel)
    {
        $this->userModel = $userModel;
        $this->ratingMovieModel = $ratingMovieModel;
        $this->ratingSeriesModel = $ratingSeriesModel;
        $this->ratingSeasonModel = $ratingSeasonModel;
        $this->ratingBookModel = $ratingBookModel;
        $this->ratingMusicModel = $ratingMusicModel;
        $this->ratingGameModel = $ratingGameModel;
	}

	public function render()
	{
		$this->template->activeUsers = $this->userModel->getActivity();

        $this->template->movieMax = $this->ratingMovieModel->getMaxRatingCount();
        $this->template->seriesMax = $this->ratingSeriesModel->getMaxRatingCount();
        $this->template->seasonMax = $this->ratingSeasonModel->getMaxRatingCount();
        $this->template->bookMax = $this->ratingBookModel->getMaxRatingCount();
        $this->template->musicMax = $this->ratingMusicModel->getMaxRatingCount();
        $this->template->gameMax = $this->ratingGameModel->getMaxRatingCount();

		parent::render();
	}
}
