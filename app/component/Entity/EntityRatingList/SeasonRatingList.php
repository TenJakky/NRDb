<?php

namespace App\Component;

final class SeasonRatingList extends EntityRatingList
{
    public function __construct(
        \App\Model\RatingSeasonModel $ratingSeasonModel)
    {
        parent::__construct();
        $this->model = $ratingSeasonModel;
    }
}
