<?php

namespace App\UserModule\Presenter;

final class ProfilePresenter extends \App\Presenter\BaseViewPresenter
{
    public function __construct(
        \Nepttune\Model\Authenticator $userModel)
    {
        $this->model = $userModel;
    }

    public function actionDefault()
    {
        $this->forward(':User:Profile:view', $this->getUser()->getId());
    }
}
