<?php

namespace App\Presenter;

final class GamePresenter extends BaseEntityPresenter
{
    protected $ratingModel;

    public function __construct(
        \App\Model\GameModel $gameModel,
        \App\Model\RatingGameModel $ratingGameModel)
    {
        $this->model = $gameModel;
        $this->ratingModel = $ratingGameModel;
    }
}
