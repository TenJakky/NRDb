<?php

namespace App\UserModule\Presenter;

final class DefaultPresenter extends \Peldax\NetteInit\Presenter\BaseAuthPresenter
{
    public function actionDefault()
    {
        $this->forward(':User:Profile:view', $this->getUser()->getId());
    }
}
