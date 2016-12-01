<?php

namespace App\Model;

class RatingMovieModel extends BaseModel
{
    protected $tableName = 'rating_movie';

    public function getRating($movieId)
    {
        $result = $this->context->query(
            "select sum(rating) as `sum`, count(*) as `size` from ratings_movie ".
            "where ratings_movie.movie_id = {$movieId}"
        )->fetch();

        if ($result['size'] === 0)
        {
            return 0;
        }
        return $result['sum'] / $result['size'];
    }

    public function getUserRating($movieId, $userId)
    {
        return $this->findByArray(array('movie_id' => $movieId, 'user_id' => $userId))->fetch();
    }

    public function getWomenRating($movieId)
    {
        $result = $this->context->query(
        "select sum(ratings_movie.rating) as `sum`, count(*) as `size` from ratings_movie ".
        "left join users on ratings_movie.user_id = users.id ".
        "where ratings_movie.movie_id = {$movieId} AND users.gender = 'Female'")->fetch();

        if ($result['size'] === 0)
        {
            return 0;
        }
        return $result['sum'] / $result['size'];
    }

    public function getMenRating($movieId)
    {
        $result = $this->context->query(
            "select sum(ratings_movie.rating) as `sum`, count(*) as `size` from ratings_movie ".
            "left join users on ratings_movie.user_id = users.id ".
            "where ratings_movie.movie_id = {$movieId} AND users.gender = 'Male'")->fetch();

        if ($result['size'] === 0)
        {
            return 0;
        }
        return $result->sum / $result['size'];
    }
}