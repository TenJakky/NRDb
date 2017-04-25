<?php

namespace App\Component;

final class EntitySmallList extends BaseComponent
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

    public function render($listType)
    {
        $perPage = $this->presenter->getUser()->getIdentity()->per_page_small;
        $userId = $this->presenter->getUser()->getId();

        switch ($listType)
        {
            default:
            case 'new':
                $data = $this->model->getRecentWithRating($userId);
                break;
            case 'top':
                $data = $this->model->getTopWithRating($userId);
                break;
            case 'notRated':
                $data = $this->model->getNotRatedWithRating($userId);
                break;
        }

        $data = $data->where('type', $this->presenter->type)->limit($perPage)->fetchAll();

        $this->template->ratingModel = $this->ratingModel;
        $this->template->entities = $data;

        $this->template->setFile(__DIR__.'/EntitySmallList.latte');
        $this->template->render();
    }
}
