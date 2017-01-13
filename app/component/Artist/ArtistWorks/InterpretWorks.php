<?php

namespace App\Component;

final class InterpretWorks extends ArtistWorks
{
    public function __construct(
        \App\Model\MusicModel $musicModel,
        \App\Model\RatingMusicModel $ratingMusicModel)
    {
        parent::__construct();

        $this->model = $musicModel;
        $this->ratingModel = $ratingMusicModel;
        $this->entityType = 'Music';
        $this->artistType = 'interpret';
    }
}
