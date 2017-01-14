<?php

namespace App\Component;

final class SeasonList extends EntityList
{
    public function __construct(
        \App\Model\SeasonModel $seasonModel,
        \App\Model\RatingSeasonModel $ratingSeasonModel)
    {
        parent::__construct();

        $this->model = $seasonModel;
        $this->ratingModel = $ratingSeasonModel;
        $this->makerType = 'director';
        $this->entityType = 'Season';
    }
}
