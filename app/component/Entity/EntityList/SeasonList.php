<?php

namespace App\Component;

final class SeasonList extends EntityList
{
    public function __construct(
        \App\Model\SeriesSeasonModel $seriesSeasonModel,
        \App\Model\RatingSeriesSeasonModel $ratingSeriesSeasonModel)
    {
        parent::__construct();

        $this->model = $seriesSeasonModel;
        $this->ratingModel = $ratingSeriesSeasonModel;
        $this->makerType = 'director';
        $this->entityType = 'Season';
    }
}
