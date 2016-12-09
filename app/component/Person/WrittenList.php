<?php

namespace App\Component;

final class WrittenList extends PersonEntityList
{
    public function __construct(
        \App\Model\BookModel $bookModel,
        \App\Model\RatingBookModel $ratingBookModel)
    {
        parent::__construct();

        $this->model = $bookModel;
        $this->ratingModel = $ratingBookModel;
        $this->pTarget = 'Book';
    }

    public function getDataSource($filter, $order)
    {
        return $this->model->findBy(':book2author.person_id', $this->personId)->order('year DESC');
    }
}
