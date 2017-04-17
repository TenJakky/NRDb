<?php

namespace App\Component;

final class StatElementCount extends BaseComponent
{
    /** @var \App\Model\StatEntityModel */
    protected $statEntityModel;

    /** @var \App\Model\StatRatingModel  */
    protected $statRatingModel;

    public function __construct(
        \App\Model\StatEntityModel $statEntityModel,
        \App\Model\StatRatingModel $statRatingModel)
    {
        $this->statEntityModel = $statEntityModel;
        $this->statRatingModel = $statRatingModel;
    }

    public function render()
    {
        $this->template->statEntity = $this->statEntityModel->getRatingData();
        $this->template->statRating = $this->statRatingModel->getTable();

        parent::render();
    }
}
