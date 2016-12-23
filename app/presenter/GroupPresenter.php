<?php

namespace App\Presenter;

final class GroupPresenter extends BaseViewPresenter
{
    public function __construct(
        \App\Model\GroupModel $groupModel)
    {
        $this->model = $groupModel;
    }

    public function actionEdit($id)
    {
        $this->template->id = $id;
    }
}
