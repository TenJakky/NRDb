<?php

namespace App\Component;

abstract class SmallList extends BaseComponent
{
    protected $model;
    protected $ratingModel;

    public function render($type = 0)
    {
        $perPage = $this->presenter->getUser()->getIdentity()->per_page_small;
        $userId = $this->presenter->getUser()->getId();

        switch ($type)
        {
            default:
            case 'new':
                $data = $this->model->getRecent($perPage);
                break;
            case 'top':
                $data = $this->model->getTop($perPage);
                break;
            case 'notRated':
                $data = $this->model->getNotRated($userId, $perPage);
                break;
        }

        $this->template->name = $this->presenter->getName();
        $this->template->userId = $userId;
        $this->template->ratingModel = $this->ratingModel;
        $this->template->entities = $data;

        $this->template->setFile(__DIR__.'/SmallList.latte');
        $this->template->render();
    }
}
