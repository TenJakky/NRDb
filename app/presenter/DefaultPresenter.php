<?php

namespace App\Presenter;

final class DefaultPresenter extends BasePresenter
{
    public function actionLogout()
    {
        $this->user->logout();

        $this->flashMessage('Successfully logged out.', 'success');
        $this->redirect('Default:login');
    }
}
