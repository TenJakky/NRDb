<?php

namespace App\Model;

class MovieModel extends BaseModel
{
    public $tableName = 'movie';

    const FILE_DIR = '/images/movie/';

    protected $ratingMovieModel;
    protected $movieDirectorModel;
    protected $movieActorModel;

    public function __construct(
        \Nette\Database\Context $context,
        \App\Model\RatingMovieModel $ratingMovieModel,
        \App\Model\MovieDirectorModel $movieDirectorModel,
        \App\Model\MovieActorModel $movieActorModel)
    {
        parent::__construct($context);

        $this->ratingMovieModel = $ratingMovieModel;
        $this->movieDirectorModel = $movieDirectorModel;
        $this->movieActorModel = $movieActorModel;
    }

    public function getTopMovie($directorId)
    {
        return $this->query(
        "SELECT
        movie.*
        FROM movie
        LEFT JOIN rating_movie ON movie.id = rating_movie.movie_id
        LEFT JOIN movie2director ON movie.id = movie2director.movie_id
        WHERE movie2director.person_id = {$directorId}
        GROUP BY movie.id
        ORDER BY sum(rating_movie.rating) DESC")->fetch();
    }

    public function getAverageRating($directorId)
    {
        $result = $this->ratingMovieModel->query(
        "SELECT
        sum(`subsum`) AS `sum`,
        count(*) AS `size`
        FROM
        (
        SELECT 
        (sum(rating_movie.rating) / count(*)) as `subsum`
        FROM movie2director
        LEFT JOIN rating_movie ON rating_movie.movie_id = movie2director.movie_id
        WHERE movie2director.person_id = {$directorId}
        GROUP BY rating_movie.movie_id
        ) AS `alias`")->fetch();

        return $result->size ? $result->sum / $result->size : null;
    }
}