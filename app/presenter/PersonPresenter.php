<?php

namespace App\Presenter;

final class PersonPresenter extends BaseViewPresenter
{
    public function __construct(
        \App\Model\PersonModel $personModel)
    {
        $this->model = $personModel;
    }

    public function actionEdit($id)
    {
        $this->template->id = $id;
    }

    public function actionEditPseudonym($id)
    {
        $this->template->id = $id;
    }
}
