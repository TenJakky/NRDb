<?php

namespace App\Presenter;

abstract class BaseViewPresenter extends BasePresenter
{
    public function actionView($id)
    {
        $data = $this->model->findRow($id);

        if (!$data)
        {
            $this->flashMessage($this->name.' was not found.', 'failure');
            $this->redirect('Default:default');
        }

        $this->template->data = $data;
    }
}