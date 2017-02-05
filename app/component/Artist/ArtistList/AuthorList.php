<?php

namespace App\Component;

final class AuthorList extends ArtistList
{
    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\BookModel $bookModel)
    {
        parent::__construct();

        $this->model = $personModel;
        $this->entityModel = $bookModel;
        $this->artistType = 'author';
    }
}
