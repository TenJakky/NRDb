<?php

namespace App\Presenter;

final class PersonPresenter extends BaseViewEditPresenter
{
    public function __construct(
        \App\Model\PersonModel $personModel)
    {
        $this->model = $personModel;
    }

    public function actionEditPseudonym($id)
    {
        $this->template->id = $id;
    }
}
