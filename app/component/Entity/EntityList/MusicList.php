<?php

namespace App\Component;

final class MusicList extends EntityList
{
    public function __construct(
        \App\Model\MusicModel $musicModel,
        \App\Model\RatingMusicModel $ratingMusicModel)
    {
        parent::__construct();

        $this->model = $musicModel;
        $this->ratingModel = $ratingMusicModel;
        $this->artistType = 'interpret';
        $this->entityType = 'music';
    }
}
