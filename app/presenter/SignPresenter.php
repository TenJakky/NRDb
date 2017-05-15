<?php

namespace App\Presenter;

final class SignPresenter extends BasePresenter
{
    /** @persistent */
    public $backlink;

    public function actionOut()
    {
        $this->user->logout();

        $this->flashMessage('Successfully logged out.', 'success');
        $this->redirect('Sign:in');
    }
}
