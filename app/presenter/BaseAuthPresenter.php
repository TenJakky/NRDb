<?php

namespace App\Presenter;

abstract class BaseAuthPresenter extends BasePresenter
{
    public function startup() : void
    {
        if (!$this->user->isLoggedIn() && $this->getName())
        {
            $this->redirect(':User:Sign:in', ['backlink' => $this->storeRequest()]);
        }

        parent::startup();
    }
}