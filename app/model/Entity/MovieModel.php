<?php

namespace App\Model;

final class MovieModel extends BaseEntityModel
{
    public $tableName = 'movie';

    public function getTopDirectorMovie($directorId)
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

    public function getTopActorMovie($actorId)
    {
        return $this->query(
            "SELECT
        movie.*
        FROM movie
        LEFT JOIN rating_movie ON movie.id = rating_movie.movie_id
        LEFT JOIN movie2actor ON movie.id = movie2actor.movie_id
        WHERE movie2actor.person_id = {$actorId}
        GROUP BY movie.id
        ORDER BY sum(rating_movie.rating) DESC")->fetch();
    }

    public function getAverageDirectorRating($directorId)
    {
        $result = $this->query(
        "SELECT
        sum(`subsum`) AS `sum`,
        count(*) AS `size`
        FROM (
        SELECT 
        (sum(rating_movie.rating) / count(*)) as `subsum`
        FROM movie2director
        LEFT JOIN rating_movie ON rating_movie.movie_id = movie2director.movie_id
        WHERE movie2director.person_id = {$directorId}
        GROUP BY rating_movie.movie_id
        ) AS `subquery`")->fetch();

        return $result->size ? $result->sum / $result->size : null;
    }

    public function getAverageActorRating($actorId)
    {
        $result = $this->query(
        "SELECT
        sum(`subsum`) AS `sum`,
        count(*) AS `size`
        FROM (
        SELECT 
        (sum(rating_movie.rating) / count(*)) as `subsum`
        FROM movie2actor
        LEFT JOIN rating_movie ON rating_movie.movie_id = movie2actor.movie_id
        WHERE movie2actor.person_id = {$actorId}
        GROUP BY rating_movie.movie_id
        ) AS `subquery`")->fetch();

        return $result->size ? $result->sum / $result->size : null;
    }
}
