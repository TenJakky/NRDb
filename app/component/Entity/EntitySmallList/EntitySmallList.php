<?php

namespace App\Component;

abstract class EntitySmallList extends BaseComponent
{
    /** @var \App\Model\BaseEntityModel */
    protected $model;

    /** @var \App\Model\BaseRatingModel */
    protected $ratingModel;

    public function render($type = 0)
    {
        $perPage = $this->presenter->getUser()->getIdentity()->per_page_small;
        $userId = $this->presenter->getUser()->getId();

        switch ($type)
        {
            default:
            case 'new':
                $data = $this->model->getRecent($perPage)->fetchAll();
                break;
            case 'top':
                $data = $this->model->getTop($perPage)->fetchAll();
                break;
            case 'notRated':
                $data = $this->model->getNotRated($userId, $perPage)->fetchAll();
                break;
        }

        $this->template->pName = $this->presenter->getName();
        $this->template->userId = $userId;
        $this->template->ratingModel = $this->ratingModel;
        $this->template->entities = $data;

        $this->template->setFile(__DIR__.'/EntitySmallList.latte');
        $this->template->render();
    }
}
