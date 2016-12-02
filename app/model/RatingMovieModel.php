<?php

namespace App\Model;

class RatingMovieModel extends BaseModel
{
    public $tableName =  'rating_movie';

    public function getRating($movieId)
    {
        $result = $this->context->query(
        "select sum(rating) as `sum`, count(*) as `size` from {$this->tableName} ".
        "where {$this->tableName}.movie_id = {$movieId}")->fetch();

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
        "select sum({$this->tableName}.rating) as `sum`, count(*) as `size` from {$this->tableName} ".
        "left join user on {$this->tableName}.user_id = user.id ".
        "where {$this->tableName}.movie_id = {$movieId} AND user.gender = 'Female'")->fetch();

        if ($result['size'] === 0)
        {
            return 0;
        }
        return $result['sum'] / $result['size'];
    }

    public function getMenRating($movieId)
    {
        $result = $this->context->query(
            "select sum({$this->tableName}.rating) as `sum`, count(*) as `size` from {$this->tableName} ".
            "left join user on {$this->tableName}.user_id = user.id ".
            "where {$this->tableName}.movie_id = {$movieId} AND user.gender = 'Male'")->fetch();

        if ($result['size'] === 0)
        {
            return 0;
        }
        return $result->sum / $result['size'];
    }
}