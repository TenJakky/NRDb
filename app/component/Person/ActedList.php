<?php

namespace App\Component;

final class ActedList extends PersonEntityList
{
    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        parent::__construct();

        $this->model = $movieModel;
        $this->ratingModel = $ratingMovieModel;
        $this->pTarget = 'Movie';
    }

    public function getDataSource($filter, $order)
    {
        return $this->model->findBy(':movie2actor.person_id', $this->personId)->order('year DESC');
    }
}
