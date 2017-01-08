<?php

namespace App\Component;

final class RatingListSeries extends RatingList
{
    public function __construct(
        \App\Model\RatingSeriesModel $ratingSeriesModel)
    {
        parent::__construct();
        $this->model = $ratingSeriesModel;
    }
}
