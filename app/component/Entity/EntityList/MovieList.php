<?php

namespace App\Component;

final class MovieList extends EntityList
{
    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        parent::__construct();

        $this->model = $movieModel;
        $this->ratingModel = $ratingMovieModel;
        $this->makerType = 'director';
        $this->entityType = 'Movie';
    }
}
