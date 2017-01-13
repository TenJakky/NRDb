<?php

namespace App\Component;

final class MusicSmallList extends EntitySmallList
{
    public function __construct(
        \App\Model\MusicModel $musicModel,
        \App\Model\RatingMusicModel $ratingMusicModel)
    {
        $this->model = $musicModel;
        $this->ratingModel = $ratingMusicModel;
    }
}
