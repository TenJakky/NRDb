<?php

namespace App\Model;

class UserModel extends \Peldax\NetteInit\Model\BaseModel
{
    public $tableName = 'user';

    public function getMaxRatings()
    {
        return $this->getTable()
            ->select('
            MAX(ratings_movie) AS movie,
            MAX(ratings_series) AS series,
            MAX(ratings_season) AS season,
            MAX(ratings_book) AS book,
            MAX(ratings_music) AS music,
            MAX(ratings_game) AS game
            ')->fetch();
    }
}
