<?php

namespace App\Presenter;

final class SeasonPresenter extends BaseEntityPresenter
{
    protected $ratingModel;

    public function __construct(
        \App\Model\SeasonModel $seasonModel,
        \App\Model\RatingSeasonModel $ratingSeasonModel)
    {
        $this->model = $seasonModel;
        $this->ratingModel = $ratingSeasonModel;
    }
}
