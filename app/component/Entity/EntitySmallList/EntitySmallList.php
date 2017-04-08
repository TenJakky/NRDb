<?php

namespace App\Component;

class EntitySmallList extends BaseComponent
{
    /** @var \App\Model\EntityModel */
    protected $model;

    /** @var \App\Model\RatingModel */
    protected $ratingModel;

    public function __construct(
        \App\Model\EntityModel $entityModel,
        \App\Model\RatingModel $ratingModel)
    {
        $this->model = $entityModel;
        $this->ratingModel = $ratingModel;
    }

    public function render($eType = 0, $type = 0)
    {
        $perPage = $this->presenter->getUser()->getIdentity()->per_page_small;
        $userId = $this->presenter->getUser()->getId();

        switch ($type)
        {
            default:
            case 'new':
                $data = $this->model->getRecent($perPage)->where('type', $eType)->fetchAll();
                break;
            case 'top':
                $data = $this->model->getTop($perPage)->where('type', $eType)->fetchAll();
                break;
            case 'notRated':
                $data = $this->model->getNotRated($userId, $perPage)->where('type', $eType)->fetchAll();
                break;
        }

        $this->template->ratingModel = $this->ratingModel;
        $this->template->entities = $data;

        $this->template->setFile(__DIR__.'/EntitySmallList.latte');
        $this->template->render();
    }
}
