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
        $this->makerType = 'director';
        $this->entityType = 'Series';
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addCellsTemplate(__DIR__ . '/SeriesListCellsTemplate.latte');

        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $set = parent::getDataSource($filter, $order);

        return $set
            ->select('*, ent_series.id AS id, MIN(:ent_season.year) AS year_min, MAX(:ent_season.year) AS year_max')
            ->group('ent_series.id');
    }
}
