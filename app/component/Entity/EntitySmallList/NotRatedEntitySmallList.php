<?php

namespace App\Component;

final class NotRatedEntitySmallList extends EntitySmallList
{
    public function getDataSource($filter, $order)
    {
        return $this->model
            ->getNotRatedWithRating($this->presenter->getUser()->getId())
            ->where('type', $this->presenter->type);
    }
}
