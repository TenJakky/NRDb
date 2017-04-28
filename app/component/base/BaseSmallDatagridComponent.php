<?php

namespace App\Component;

abstract class BaseSmallDatagridComponent extends BaseDatagridComponent
{
    public function attached($presenter)
    {
        $this->perPage = $presenter->getUser()->getIdentity()->per_page_small;
    }
}
