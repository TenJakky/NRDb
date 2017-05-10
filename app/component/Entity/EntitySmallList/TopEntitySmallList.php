<?php

namespace App\Component;

final class TopEntitySmallList extends EntitySmallList
{
    public function getDataSource($filter, $order)
    {
        return $this->model
            ->getTopWithRating($this->presenter->getUser()->getId())
            ->where('type', $this->presenter->type);
    }
}
