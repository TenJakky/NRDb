<?php

namespace App\Component;

final class GameSmallList extends EntitySmallList
{
    public function __construct(
        \App\Model\GameModel $gameModel,
        \App\Model\RatingGameModel $ratingGameModel)
    {
        $this->model = $gameModel;
        $this->ratingModel = $ratingGameModel;
    }
}
