<?php

namespace App\Component;

final class RecentEntitySmallList extends EntitySmallList
{
    public function getDataSource($filter, $order)
    {
        return $this->model
            ->getRecentWithRating($this->getPresenter()->getUser()->getId())
            ->where('type', $this->getPresenter()->type);
    }
}
