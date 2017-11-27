<?php

namespace App\UserModule\Presenter;

final class SignPresenter extends \Peldax\NetteInit\Presenter\BasePresenter
{
    /** @persistent */
    public $backlink;

    public function actionOut()
    {
        $this->user->logout();

        $this->flashMessage('Successfully logged out.', 'success');
        $this->redirect(':User:Sign:in');
    }
}
