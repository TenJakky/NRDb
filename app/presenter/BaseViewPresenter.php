<?php

namespace App\Presenter;

class BaseViewPresenter extends BasePresenter
{
    public function actionView($id)
    {
        if (!$id || !($data = $this->model->findRow($id)))
        {
            $this->flashMessage($this->name.' was not found.', 'failure');
            $this->redirect('Default:default');
        }

        $this->template->data = $data;
    }
}