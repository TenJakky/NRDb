<?php
namespace App\Model;

class MovieModel extends BaseModel
{
    protected $tableName = 'movie';

    const FILE_DIR = '/images/movie/';

    protected $ratingMovieModel;
    protected $movieDirectorModel;
    protected $movieActorModel;

    public function __construct(
        \App\Model\RatingMovieModel $ratingMovieModel,
        \App\Model\MovieDirectorModel $movieDirectorModel,
        \App\Model\MovieActorModel $movieActorModel,
        \Nette\Database\Context $context)
    {
        parent::__construct($context);

        $this->ratingMovieModel = $ratingMovieModel;
        $this->movieDirectorModel = $movieDirectorModel;
        $this->movieActorModel = $movieActorModel;
    }

    public function getTopMovie($directorId)
    {
        return $this->query(
            "select 
                {$this->tableName}.*
                from {$this->tableName}
                left join ratings_movie on {$this->tableName}.id = ratings_movie.movie_id
                where {$this->tableName}.director_id = {$directorId}
                order by sum(ratings_movie.rating) DESC"
        )->fetch();
    }

    public function getAverageRating($directorId)
    {
        $set = $this->findBy('director_id', $directorId);
        $sum = 0;
        foreach ($set as $movie)
        {
            $sum += $this->ratingMovieModel->getRating($movie->id);
        }
        return $set->count() ? $sum / $set->count() : null;
    }
}