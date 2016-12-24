<?php

namespace App\Presenter;

abstract class BaseViewEditPresenter extends BaseViewPresenter
{
    public function actionEdit($id)
    {
        if (!$this->model->findRow($id))
        {
            $this->flashMessage($this->getName() . ' not found', 'failure');
            $this->redirect(':default');
        }

        $this->template->id = $id;
    }
}
