<?php

namespace App\Component;

final class StatElementCount extends BaseRenderComponent
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

    public function attached($presenter)
    {
        parent::attached($presenter);

        $presenter->addScript('/js/component/statElementCount.js');
    }

    public function beforeRender()
    {
        $this->template->statEntity = $this->statEntityModel->getRatingData();
        $this->template->statRating = $this->statRatingModel->getTable();
    }
}
