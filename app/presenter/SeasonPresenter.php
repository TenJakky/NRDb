<?php

namespace App\Presenter;

final class SeasonPresenter extends BaseEntityPresenter
{
    protected $ratingModel;

    public function __construct(
        \App\Model\SeasonModel $seasonModel,
        \App\Model\RatingSeasonModel $ratingSeasonModel)
    {
        $this->model = $seasonModel;
        $this->ratingModel = $ratingSeasonModel;
    }

    public function actionAdd($seriesId)
    {
        $this->template->seriesId = $seriesId;
    }

    public function actionView($id)
    {
        parent::actionView($id);

        $this->template->data = $this->model->getViewData($id);
    }
}
