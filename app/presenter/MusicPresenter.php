<?php

namespace App\Presenter;

final class MusicPresenter extends BaseEntityPresenter
{
    protected $model;
    protected $ratingModel;

    public function __construct(
        \App\Model\MusicModel $musicModel,
        \App\Model\RatingMusicModel $ratingMusicModel)
    {
        $this->model = $musicModel;
        $this->ratingModel = $ratingMusicModel;
    }
}