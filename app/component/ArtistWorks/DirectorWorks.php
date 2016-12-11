<?php

namespace App\Component;

final class DirectorWorks extends ArtistWorks
{
    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        parent::__construct();

        $this->model = $movieModel;
        $this->ratingModel = $ratingMovieModel;
        $this->entityType = 'Movie';
        $this->artistType = 'director';
    }
}
