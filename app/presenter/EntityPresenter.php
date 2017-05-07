<?php

namespace App\Presenter;

final class EntityPresenter extends BaseViewEditPresenter
{
    /** @var  \App\Model\RatingModel */
    protected $ratingModel;

    /** @persistent */
    public $type;

    public function __construct(
        \App\Model\EntityModel $model,
        \App\Model\RatingModel $ratingModel)
    {
        $this->model = $model;
        $this->ratingModel = $ratingModel;
    }

    public function startup()
    {
        parent::startup();

        if (!$this->type)
        {
            $this->type = 'movie';
        }
    }

    public function actionView($id)
    {
        parent::actionView($id);

        if ($this->template->data['type'] === 'season')
        {
            $this->redirect('Entity:view', ['id' => $this->template->data['season_series_id'], 'type' => 'series']);
        }

        $this->template->ratingModel = $this->ratingModel;
    }

    public function actionRate($id)
    {
        $entity = $this->model->findRow($id);

        if (!$entity)
        {
            $this->flashMessage('Entity not found.', 'failure');
            $this->redirect(':closeFancy');
        }

        $rating = $this->ratingModel->findByArray([
            'user_id' => $this->getUser()->getId(),
            'entity_id' => $id
        ])->fetch();

        if ($rating)
        {
            $this->redirect('Entity:editRating', $rating->id);
        }
    }

    public function actionEditRating($id)
    {
        $rating = $this->ratingModel->findRow($id);

        if (!$rating || $rating->user_id !== $this->user->getId())
        {
            $this->flashMessage('You cannot edit this rating.', 'failure');
            $this->redirect(':closeFancy');
        }
    }
}
