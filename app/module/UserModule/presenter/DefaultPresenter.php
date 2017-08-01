<?php

namespace App\UserModule\Presenter;

final class DefaultPresenter extends \App\Presenter\BasePresenter
{
    public function actionDefault()
    {
        $this->forward(':User:Profile:view', $this->getUser()->getId());
    }
}
