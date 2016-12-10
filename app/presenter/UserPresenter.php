<?php

namespace App\Presenter;

final class UserPresenter extends BaseViewPresenter
{
    public function __construct(
        \App\Model\Authenticator $userModel)
    {
        $this->model = $userModel;
    }
}
