<?php

namespace App\Component;

final class ActorList extends MakerList
{
    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\MovieModel $movieModel)
    {
        parent::__construct();

        $this->model = $personModel;
        $this->entityModel = $movieModel;
        $this->type = 'actor';
    }
}
