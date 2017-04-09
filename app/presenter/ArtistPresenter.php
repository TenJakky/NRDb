<?php

namespace App\Presenter;

final class ArtistPresenter extends BaseViewEditPresenter
{
    public function __construct(
        \App\Model\ArtistModel $artistModel)
    {
        $this->model = $artistModel;
    }

    public function actionEditPseudonym($id)
    {
        $this->template->id = $id;
    }
}
