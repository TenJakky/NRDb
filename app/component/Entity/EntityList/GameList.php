<?php

namespace App\Component;

final class GameList extends EntityList
{
    public function __construct(
        \App\Model\GameModel $gameModel,
        \App\Model\RatingGameModel $ratingGameModel)
    {
        parent::__construct();

        $this->model = $gameModel;
        $this->ratingModel = $ratingGameModel;
        $this->artistType = 'developer';
        $this->entityType = 'game';
    }
}
