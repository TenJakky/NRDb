<?php

namespace App\Component;

final class EntityView extends BaseComponent
{
    public function render($data = null, $entityModel = null, $ratingModel = null)
    {
        $this->template->data = $data;
        $this->template->entityModel = $entityModel;
        $this->template->ratingModel = $ratingModel;

        $this->template->pname = lcfirst($this->presenter->getName());

        parent::render();
    }
}
