<?php

namespace App\Presenter;

final class PseudonymPresenter extends BaseViewPresenter
{
    public function __construct(
        \App\Model\PseudonymModel $pseudonymModel)
    {
        $this->model = $pseudonymModel;
    }
}
