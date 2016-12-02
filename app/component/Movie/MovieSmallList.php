<?php

namespace App\Component;

class MovieSmallList extends \Nette\Application\UI\Control
{
    protected $movieModel;
    protected $ratingMovieModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        $this->movieModel = $movieModel;
        $this->ratingMovieModel = $ratingMovieModel;
    }

    public function render($type)
    {
        $perPage = $this->presenter->getUser()->getIdentity()->per_page_small;
        $userId = $this->presenter->getUser()->getId();

        switch ($type)
        {
            default:
            case 'new':
                $data = $this->movieModel->findAll()->order('id DESC')->limit($perPage);
                break;
            case 'top':
                $data = $this->movieModel->query(
                "SELECT
                movie.*
                FROM movie
                LEFT JOIN rating_movie ON movie.id = rating_movie.movie_id
                GROUP BY movie.id
                ORDER BY sum(rating_movie.rating)/count(*) DESC
                LIMIT {$perPage}")->fetchAll();
                break;
            case 'notRated':
                $data = $this->movieModel->query(
                "SELECT
                movie.*
                FROM movie
                LEFT JOIN rating_movie ON movie.id = rating_movie.movie_id AND rating_movie.user_id = {$userId}
                WHERE rating_movie.user_id IS NULL
                ORDER BY movie.id DESC
                LIMIT {$perPage}")->fetchAll();
                break;
        }

        $this->template->setFile(str_replace(".php", ".latte", $this->getReflection()->getFileName()));

        $this->template->userId = $userId;
        $this->template->ratingMovieModel = $this->ratingMovieModel;
        $this->template->movies = $data;

        $this->template->render();
    }
}