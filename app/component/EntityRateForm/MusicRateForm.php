<?php

namespace App\Component;

final class MusicRateForm extends EntityRateForm
{
    public function __construct(
        \App\Model\MusicModel $musicModel,
        \App\Model\RatingMusicModel $ratingMusicModel)
    {
        $this->model= $musicModel;
        $this->ratingModel = $ratingMusicModel;
    }
}
