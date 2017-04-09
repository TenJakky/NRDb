<?php

namespace App\Model;

class RatingModel extends BaseModel
{
    /** @var string */
    public $tableName = 'rating';

    public function getUserRating($entityId, $userId)
    {
        return $this->findByArray(array('entity_id' => $entityId, 'user_id' => $userId))->fetch();
    }

    public function getRating($entityId)
    {
        return $this->getTable()
            ->select('`rating`')
            ->where('entity_id', $entityId)
            ->fetch()->rating;
    }

    public function getWomenRating($entityId)
    {
        return $this->getTable()
            ->select('sum(value) / count(*) AS `rating`')
            ->where('entity_id', $entityId)
            ->where('user.gender', 'Female')
            ->fetch()->rating;
    }

    public function getMenRating($entityId)
    {
        return $this->getTable()
            ->select('sum(value) / count(*) AS `rating`')
            ->where('entity_id', $entityId)
            ->where('user.gender', 'Male')
            ->fetch()->rating;
    }
}
