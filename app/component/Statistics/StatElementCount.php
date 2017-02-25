<?php

namespace App\Component;

class StatElementCount extends BaseComponent
{
    /** @var \App\Model\MovieModel */
    protected $movieModel;

    /** @var \App\Model\SeriesModel  */
    protected $seriesModel;

    /** @var \App\Model\SeasonModel  */
    protected $seasonModel;

    /** @var \App\Model\BookModel  */
    protected $bookModel;

    /** @var \App\Model\MusicModel  */
    protected $musicModel;

    /** @var \App\Model\GameModel  */
    protected $gameModel;

    /** @var \App\Model\RatingMovieModel  */
    protected $ratingMovieModel;

    /** @var \App\Model\RatingSeriesModel  */
    protected $ratingSeriesModel;

    /** @var \App\Model\RatingSeasonModel  */
    protected $ratingSeasonModel;

    /** @var \App\Model\RatingBookModel  */
    protected $ratingBookModel;

    /** @var \App\Model\RatingMusicModel  */
    protected $ratingMusicModel;

    /** @var \App\Model\RatingGameModel  */
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
        $total += $this->template->movieT = $this->movieModel->count();
        $total += $this->template->seriesT = $this->seriesModel->count();
        $total += $this->template->seasonT = $this->seasonModel->count();
        $total += $this->template->bookT = $this->bookModel->count();
        $total += $this->template->musicT = $this->musicModel->count();
        $total += $this->template->gameT = $this->gameModel->count();
        $this->template->total = $total;

        $totalR = 0;
        $totalR += $this->template->movieRT = $this->ratingMovieModel->count();
        $totalR += $this->template->seriesRT = $this->ratingSeriesModel->count();
        $totalR += $this->template->seasonRT = $this->ratingSeasonModel->count();
        $totalR += $this->template->bookRT = $this->ratingBookModel->count();
        $totalR += $this->template->musicRT = $this->ratingMusicModel->count();
        $totalR += $this->template->gameRT = $this->ratingGameModel->count();
        $this->template->totalR = $totalR;

        for ($i = 0; $i <= 10; $i++)
        {
            $count = 0;
            $count += $this->template->{"movie{$i}"} = $this->ratingMovieModel->findBy('rating', $i)->count();
            $count += $this->template->{"series{$i}"} = $this->ratingSeriesModel->findBy('rating', $i)->count();
            $count += $this->template->{"season{$i}"} = $this->ratingSeasonModel->findBy('rating', $i)->count();
            $count += $this->template->{"book{$i}"} = $this->ratingBookModel->findBy('rating', $i)->count();
            $count += $this->template->{"music{$i}"} = $this->ratingMusicModel->findBy('rating', $i)->count();
            $count += $this->template->{"game{$i}"} = $this->ratingGameModel->findBy('rating', $i)->count();
            $this->template->{"total{$i}"} = $count;
        }

        parent::render();
    }
}