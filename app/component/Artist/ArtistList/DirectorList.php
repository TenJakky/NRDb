<?php

namespace App\Component;

final class DirectorList extends ArtistList
{
    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\MovieModel $movieModel)
    {
        parent::__construct();

        $this->model = $personModel;
        $this->entityModel = $movieModel;
        $this->artistType = 'director';
    }
}
