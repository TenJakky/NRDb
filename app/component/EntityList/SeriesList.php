<?php

namespace App\Component;

final class SeriesList extends EntityList
{
    public function __construct(
        \App\Model\SeriesModel $seriesModel,
        \App\Model\RatingSeriesModel $ratingSeriesModel)
    {
        parent::__construct();

        $this->model = $seriesModel;
        $this->ratingModel = $ratingSeriesModel;
    }
}
