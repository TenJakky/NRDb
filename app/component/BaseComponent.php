<?php

namespace App\Component;

abstract class BaseComponent extends \Nette\Application\UI\Control
{
    protected function getPost()
    {
        return $this->getPresenter()->getPost();
    }

    public function createComponent($name, array $args = null)
    {
        if (method_exists($this, 'createComponent'.ucfirst($name)))
        {
            return parent::createComponent($name);
        }

        if ($args !== null)
        {
            return $this->getPresenter()->getContext()->createService($name, $args);
        }

        return $this->getPresenter()->getContext()->createService($name);
    }
}
