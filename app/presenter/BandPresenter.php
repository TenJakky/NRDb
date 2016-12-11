<?php

namespace App\Presenter;

final class BandPresenter extends BaseViewPresenter
{
    public function __construct(
        \App\Model\BandModel $bandModel)
    {
        $this->model = $bandModel;
    }
}
