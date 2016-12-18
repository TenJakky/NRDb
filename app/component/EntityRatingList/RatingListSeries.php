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

    public function getDataSource($filter, $order)
    {
        return $this->model->findBy('series_season_id', $this->entityId)->group('series_season.series_id');

    }
}
