<?php

namespace App\Presenter;

final class GroupPresenter extends BaseViewPresenter
{
    public function __construct(
        \App\Model\PersonGroupModel $personGroupModel)
    {
        $this->model = $personGroupModel;
    }
}
