<?php

namespace App\Model;

class UserModel extends BaseModel
{
    public $tableName = 'user';

    public function getActivity()
    {
        return $this->query(
        "SELECT
        *,
        `movie` + `series` + `book` + `game` as `total`
        FROM
        (
        SELECT
        user.id,
        user.username,
        count(rating_movie.id) as `movie`,
        count(rating_series.id) as `series`,
        count(rating_book.id) as `book`,
        count(rating_game.id) as `game`
        FROM user
        LEFT JOIN rating_movie on rating_movie.user_id = user.id
        LEFT JOIN rating_series on rating_series.user_id = user.id
        LEFT JOIN rating_book on rating_book.user_id = user.id
        LEFT JOIN rating_game on rating_game.user_id = user.id
        GROUP BY user.id
        ) as `subquery`
        ORDER BY `total` DESC
        LIMIT 5")->fetchAll();
    }
}