<?php

namespace App\Component;

final class GameRateForm extends EntityRateForm
{
    public function __construct(
        \App\Model\GameModel $gameModel,
        \App\Model\RatingGameModel $ratingGameModel)
    {
        $this->model= $gameModel;
        $this->ratingModel = $ratingGameModel;
    }
}
