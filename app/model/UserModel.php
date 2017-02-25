<?php

namespace App\Model;

class UserModel extends BaseModel
{
    public $tableName = 'user';

    public function getActivity($limit = 5)
    {
        return $this->query(
        "SELECT
        user.id,
        user.username,
        `movie`,
        `series`,
        `season`,
        `book`,
        `music`,
        `game`,
        `movie` + `series` + `season` + `book` + `music` + `game` as `total`
        FROM user
        
        LEFT JOIN (
        SELECT
        user.id AS `id`,
        count(rating_movie.id) as `movie`
        FROM user
        LEFT JOIN rating_movie on rating_movie.user_id = user.id
        GROUP BY user.id
        ) AS `sq_movie` ON user.id = `sq_movie`.`id`
        
        LEFT JOIN (
        SELECT
        user.id AS `id`,
        count(rating_series.id) as `series`
        FROM user
        LEFT JOIN rating_series on rating_series.user_id = user.id
        GROUP BY user.id
        ) AS `sq_series` ON user.id = `sq_series`.`id`
        
        LEFT JOIN (
        SELECT
        user.id AS `id`,
        count(rating_season.id) as `season`
        FROM user
        LEFT JOIN rating_season on rating_season.user_id = user.id
        GROUP BY user.id
        ) AS `sq_season` ON user.id = `sq_season`.`id`
        
        LEFT JOIN (
        SELECT
        user.id AS `id`,
        count(rating_book.id) as `book`
        FROM user
        LEFT JOIN rating_book on rating_book.user_id = user.id
        GROUP BY user.id
        ) AS `sq_book` ON user.id = `sq_book`.`id`
        
        LEFT JOIN (
        SELECT
        user.id AS `id`,
        count(rating_music.id) as `music`
        FROM user
        LEFT JOIN rating_music on rating_music.user_id = user.id
        GROUP BY user.id
        ) AS `sq_music` ON user.id = `sq_music`.`id`
        
        LEFT JOIN (
        SELECT
        user.id AS `id`,
        count(rating_game.id) as `game`
        FROM user
        LEFT JOIN rating_game on rating_game.user_id = user.id
        GROUP BY user.id
        ) AS `sq_game` ON user.id = `sq_game`.`id`
        
        ORDER BY `total` DESC
        LIMIT ?", $limit)->fetchAll();
    }
}