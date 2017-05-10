<?php

namespace App\Component;

final class RecentEntitySmallList extends EntitySmallList
{
    public function getDataSource($filter, $order)
    {
        return $this->model
            ->getRecentWithRating($this->presenter->getUser()->getId())
            ->where('type', $this->presenter->type);
    }
}
