<?php

namespace App\Component;

final class SeasonRateForm extends EntityRateForm
{
    public function __construct(
        \App\Model\SeasonModel $seasonModel,
        \App\Model\RatingSeasonModel $ratingSeasonModel)
    {
        $this->model= $seasonModel;
        $this->ratingModel = $ratingSeasonModel;
    }
}
