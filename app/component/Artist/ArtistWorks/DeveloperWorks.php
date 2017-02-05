<?php

namespace App\Component;

final class DeveloperWorks extends ArtistWorks
{
    public function __construct(
        \App\Model\GameModel $gameModel,
        \App\Model\RatingGameModel $ratingGameModel)
    {
        parent::__construct();

        $this->model = $gameModel;
        $this->ratingModel = $ratingGameModel;
        $this->entityType = 'Game';
        $this->artistType = 'developer';
    }
}
