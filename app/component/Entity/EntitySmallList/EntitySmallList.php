<?php

namespace App\Component;

class EntitySmallList extends \Nette\Application\UI\Control
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

    public function render($entityType, $listType)
    {
        $perPage = $this->presenter->getUser()->getIdentity()->per_page_small;
        $userId = $this->presenter->getUser()->getId();

        switch ($listType)
        {
            default:
            case 'new':
                $data = $this->model->getRecent($perPage)->where('type', $entityType)->fetchAll();
                break;
            case 'top':
                $data = $this->model->getTop($perPage)->where('type', $entityType)->fetchAll();
                break;
            case 'notRated':
                $data = $this->model->getNotRated($userId, $perPage)->where('type', $entityType)->fetchAll();
                break;
        }

        $this->template->ratingModel = $this->ratingModel;
        $this->template->entities = $data;

        $this->template->setFile(__DIR__.'/EntitySmallList.latte');
        $this->template->render();
    }
}
