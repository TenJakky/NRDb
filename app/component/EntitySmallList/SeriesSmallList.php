<?php

namespace App\Component;

final class SeriesSmallList extends EntitySmallList
{
    public function __construct(
        \App\Model\SeriesModel $seriesModel,
        \App\Model\RatingSeriesModel $ratingSeriesModel)
    {
        $this->model = $seriesModel;
        $this->ratingModel = $ratingSeriesModel;
    }
}
