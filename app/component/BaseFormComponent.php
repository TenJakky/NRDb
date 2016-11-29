<?php

namespace App\Component;

class BaseFormComponent extends \Nette\Application\UI\Control
{
    public function render()
    {
        $this->template->setFile(str_replace(".php", ".latte", $this->getReflection()->getFileName()));
        $this->template->render();
    }
}