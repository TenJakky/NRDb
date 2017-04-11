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

        $this->template->entityModel = $this->model;
    }

    public function actionRate($id = 0)
    {
        $name = lcfirst($this->name);

        if ($id != 0 && !$this->model->findRow($id))
        {
            $this->presenter->flashMessage("Entity not found.", 'failure');
            $this->presenter->redirect("Entity:default");
        }

        $rating = $this->ratingModel->findByArray(array('user_id' => $this->getUser()->getId(), "{$name}_id" => $id));
        if ($rating->count() > 0)
        {
            $this->presenter->redirect("Entity:editRating", $rating->fetch()->id);
        }

        $this->template->id = $id;
    }

    public function actionEditRating($id)
    {
        $rating = $this->ratingModel->findRow($id);
        if ($rating->user_id !== $this->user->getId())
        {
            $this->presenter->flashMessage('You cannot edit rating of someone else.', 'failure');
            $this->presenter->redirect("{$this->name}:default");
        }

        $this->template->ratingId = $id;
    }
}
