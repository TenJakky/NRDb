<?php

namespace App\Component;

final class InterpretList extends ArtistList
{
    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\MusicModel $musicModel)
    {
        parent::__construct();

        $this->model = $personModel;
        $this->entityModel = $musicModel;
        $this->makerType = 'interpret';
    }
}
