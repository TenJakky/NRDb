<?php

namespace App\Component;

final class MusicRatingList extends EntityRatingList
{
    public function __construct(
        \App\Model\RatingMusicModel $ratingMusicModel)
    {
        parent::__construct();
        $this->model = $ratingMusicModel;
    }
}
