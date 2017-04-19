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

    public function actionRate($id = 0)
    {
        if ($id === 0 || !$this->model->findRow($id))
        {
            $this->flashMessage("Entity not found.", 'failure');
            $this->redirect("Entity:default");
        }

        $rating = $this->ratingModel->findByArray(array('user_id' => $this->getUser()->getId(), "entity_id" => $id));
        if ($rating->count() > 0)
        {
            $this->redirect("Entity:editRating", $rating->fetch()->id);
        }

        $this->template->id = $id;
    }

    public function actionEditRating($id)
    {
        $rating = $this->ratingModel->findRow($id);

        if (!$rating || $rating->user_id !== $this->user->getId())
        {
            $this->flashMessage('You cannot edit rating of someone else.', 'failure');
            $this->redirect("Entity:default");
        }

        $this->template->ratingId = $id;
    }

    public function actionRemoveRating($id)
    {
        $rating = $this->ratingModel->findRow($id);
        if (!$rating || $rating->user_id !== $this->user->getId())
        {
            $this->flashMessage('You cannot remove rating of someone else.', 'failure');
            $this->redirect("Entity:default");
        }

        $rating->delete();

        $this->redirect("Entity:default");
    }
}
