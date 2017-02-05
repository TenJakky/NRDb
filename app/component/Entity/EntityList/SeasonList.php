<?php

namespace App\Component;

final class SeasonList extends EntityList
{
    /**@var int */
    protected $seriesId;

    public function render($seriesId = null)
    {
        $this->seriesId = $seriesId;

        parent::render();
    }

    public function getDataSource($filter, $order)
    {
        $filter['series_id'] = $this->seriesId;

        return parent::getDataSource($filter, $order);
    }

    public function __construct(
        \App\Model\SeasonModel $seasonModel,
        \App\Model\RatingSeasonModel $ratingSeasonModel)
    {
        parent::__construct();

        $this->model = $seasonModel;
        $this->ratingModel = $ratingSeasonModel;
        $this->artistType = 'director';
        $this->entityType = 'season';
    }
}
