<?php

namespace App\Presenter;

final class UserPresenter extends BaseViewPresenter
{
    protected $model;

    public function __construct(
        \App\Model\Authenticator $userModel)
    {
        $this->model = $userModel;
    }
}
