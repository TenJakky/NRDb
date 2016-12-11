<?php

namespace App\Component;

final class AuthorWorks extends ArtistWorks
{
    public function __construct(
        \App\Model\BookModel $bookModel,
        \App\Model\RatingBookModel $ratingBookModel)
    {
        parent::__construct();

        $this->model = $bookModel;
        $this->ratingModel = $ratingBookModel;
        $this->entityType = 'Book';
        $this->artistType = 'author';
    }
}
