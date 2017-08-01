<?php

namespace App\Component;

abstract class BaseRenderComponent extends BaseComponent
{
    public function beforeRender()
    {

    }

    public function render()
    {
        $this->beforeRender();

        $this->template->setFile(str_replace(".php", ".latte", $this->getReflection()->getFileName()));
        $this->template->render();
    }
}
