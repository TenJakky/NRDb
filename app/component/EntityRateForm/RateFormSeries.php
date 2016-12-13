<?php

namespace App\Component;

final class RateFormSeries extends RateForm
{
    public function __construct(
        \App\Model\SeriesModel $seriesModel,
        \App\Model\RatingSeriesModel $ratingSeriesModel)
    {
        $this->model= $seriesModel;
        $this->ratingModel = $ratingSeriesModel;
    }
}
