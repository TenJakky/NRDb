<?php

namespace App\UserModule\Presenter;

final class DefaultPresenter extends \Nepttune\Presenter\BaseAuthPresenter
{
    public function actionDefault()
    {
        $this->forward(':User:Profile:view', $this->getUser()->getId());
    }
}
