<?php

namespace App\Component;

abstract class BaseComponent extends \Nette\Application\UI\Control
{
    protected function getPost()
    {
        return $this->presenter->getPost();
    }

    public function createComponent($name, array $args = null)
    {
        if (method_exists($this, 'createComponent'.ucfirst($name)))
        {
            return parent::createComponent($name);
        }
        else if ($args != null)
        {
            return $this->presenter->getContext()->createService($name, $args);
        }
        else
        {
            return $this->presenter->getContext()->createService($name);
        }
    }
}
