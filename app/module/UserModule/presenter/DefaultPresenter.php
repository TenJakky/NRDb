<?php

namespace App\UserModule\Presenter;

final class DefaultPresenter extends \App\Presenter\BaseAuthPresenter
{
    public function actionDefault()
    {
        $this->forward(':User:Profile:view', $this->getUser()->getId());
    }
}
