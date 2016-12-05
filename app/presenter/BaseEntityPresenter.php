<?php

namespace App\Presenter;

class BaseEntityPresenter extends BaseViewPresenter
{
    public function actionEditRating($id)
    {
        $this->template->ratingId = $id;
    }

    public function actionEdit($id)
    {
        $this->template->id = $id;
    }

    public function actionView($id)
    {
        parent::actionView($id);

        $this->template->ratingModel = $this->ratingModel;
    }

    public function actionRate($id = 0)
    {
        $name = lcfirst($this->name);

        if ($this->ratingModel->findByArray(array(
                'user_id' => $this->getUser()->getId(),
                "{$name}_id" => $id
            ))->count('*') > 0)
        {
            $this->presenter->flashMessage("You have already rated this {$name}.", 'failure');
            $this->presenter->redirect("{$this->name}:view", $id);
        }

        $this->template->id = $id;
    }
}