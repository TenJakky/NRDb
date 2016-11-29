<?php

namespace App\Presenter;

use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public function startup()
    {
        parent::startup();

        if (!$this->user->isLoggedIn() && $this->action != 'login')
        {
            $this->redirect('Default:login');
        }
    }

    public function flashMessage($message, $type = 'info')
    {
        $f = parent::flashMessage($message, $type);

        if ($this->isAjax())
        {
            $this->redrawControl("flashMessages");
        }

        return $f;
    }

    public function createComponent($name, array $args = null)
    {
        if (method_exists($this, 'createComponent'.ucfirst($name)))
        {
            return parent::createComponent($name);
        }
        else if ($args != null)
        {
            return $this->context->createService($name, $args);
        }
        else
        {
            return $this->context->createService($name);
        }
    }
}