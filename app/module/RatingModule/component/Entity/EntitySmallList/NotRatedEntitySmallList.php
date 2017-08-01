<?php

namespace App\Component;

final class NotRatedEntitySmallList extends EntitySmallList
{
    public function getDataSource($filter, $order)
    {
        return $this->model
            ->getNotRatedWithRating($this->getPresenter()->getUser()->getId())
            ->where('type', $this->getPresenter()->type);
    }
}
