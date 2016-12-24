<?php

namespace App\Presenter;

final class GroupPresenter extends BaseViewEditPresenter
{
    public function __construct(
        \App\Model\GroupModel $groupModel)
    {
        $this->model = $groupModel;
    }
}
