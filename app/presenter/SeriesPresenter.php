<?php

namespace App\Presenter;

final class SeriesPresenter extends BaseEntityPresenter
{
    protected $model;
    protected $ratingModel;

    public function __construct(
        \App\Model\SeriesModel $seriesModel,
        \App\Model\RatingSeriesModel $ratingSeriesModel)
    {
        $this->model = $seriesModel;
        $this->ratingModel = $ratingSeriesModel;
    }
}