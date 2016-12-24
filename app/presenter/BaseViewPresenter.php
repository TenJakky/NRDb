<?php

namespace App\Presenter;

abstract class BaseViewPresenter extends BasePresenter
{
    protected $model;

    public function actionView($id)
    {
        $data = $this->model->findRow($id);

        if (!$data)
        {
            $this->flashMessage($this->getName().' was not found.', 'failure');
            $this->redirect(':default');
        }

        $this->template->data = $data;
    }
}
