<?php

namespace App\Component;

final class SeriesRatingList extends EntityRatingList
{
    public function __construct(
        \App\Model\RatingSeriesModel $ratingSeriesModel)
    {
        parent::__construct();
        $this->model = $ratingSeriesModel;
    }
}
