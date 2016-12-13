<?php

namespace App\Component;

final class RatingListMusic extends RatingList
{
    public function __construct(
        \App\Model\RatingMusicModel $ratingMusicModel)
    {
        parent::__construct();
        $this->model = $ratingMusicModel;
    }
}
