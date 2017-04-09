<?php

namespace App\Component;

class StatUserRadar extends BaseComponent
{
    /** @var \App\Model\UserModel */
    protected $userModel;

    public function __construct(
        \App\Model\UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function render($user = null)
    {
        $this->template->statMovie = $user->ratings_movie;
        $this->template->statSeries = $user->ratings_series;
        $this->template->statSeason = $user->ratings_season;
        $this->template->statBook = $user->ratings_book;
        $this->template->statMusic = $user->ratings_music;
        $this->template->statGame = $user->ratings_game;

        $movieMax = $this->userModel->getMaxRatings('movie');
        $seriesMax = $this->userModel->getMaxRatings('series');
        $seasonMax = $this->userModel->getMaxRatings('season');
        $bookMax = $this->userModel->getMaxRatings('book');
        $musicMax = $this->userModel->getMaxRatings('music');
        $gameMax = $this->userModel->getMaxRatings('game');

        $this->template->percentMovie = $movieMax ? $this->template->statMovie  / $movieMax : 0;
        $this->template->percentSeries = $seriesMax ? $this->template->statSeries  / $seriesMax : 0;
        $this->template->percentSeason = $seasonMax ?$this->template->statSeason  / $seasonMax : 0;
        $this->template->percentBook = $bookMax ? $this->template->statBook  / $bookMax : 0;
        $this->template->percentMusic = $musicMax ? $this->template->statMusic  / $musicMax : 0;
        $this->template->percentGame = $gameMax ?$this->template->statGame / $gameMax : 0;

        parent::render();
    }
}
