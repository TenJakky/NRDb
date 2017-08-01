<?php

namespace App\RatingModule\Presenter;

final class ArtistPresenter extends \App\Presenter\BaseViewEditPresenter
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
