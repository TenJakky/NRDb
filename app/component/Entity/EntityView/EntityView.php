<?php

namespace App\Component;

final class EntityView extends BaseComponent
{
    /** @var  \App\Model\RatingModel */
    protected $ratingModel;

    /** @var  \App\Model\EntityModel */
    protected $entityModel;

    public function __construct(\App\Model\RatingModel $ratingModel, \App\Model\EntityModel $entityModel)
    {
        $this->ratingModel = $ratingModel;
        $this->entityModel = $entityModel;
    }

    public function render($data = null)
    {
        $this->template->data = $data;
        $this->template->entityModel = $this->entityModel;
        $this->template->ratingModel = $this->ratingModel;

        parent::render();
    }
}
