<?php

namespace App\Presenter;

class PersonPresenter extends BaseViewPresenter
{
    protected $model;

    public function __construct(
        \App\Model\PersonModel $personModel)
    {
        $this->model = $personModel;
    }

    public function actionEdit($id)
    {
        $this->template->id = $id;
    }
}
