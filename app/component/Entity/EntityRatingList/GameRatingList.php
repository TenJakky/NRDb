<?php

namespace App\Component;

final class GameRatingList extends EntityRatingList
{
    public function __construct(
        \App\Model\RatingGameModel $ratingGameModel)
    {
        parent::__construct();
        $this->model = $ratingGameModel;
    }
}
