<?php

namespace App\Model;

abstract class BaseRatingModel extends BaseModel
{
    public function getUserRating($entityId, $userId)
    {
        $name = substr($this->tableName, 7);
        return $this->findByArray(array("{$name}_id" => $entityId, 'user_id' => $userId))->fetch();
    }

    public function getRating($entityId)
    {
        $name = substr($this->tableName, 7);

        return $this->getTable()
            ->select('sum(rating) / count(*) AS `rating`')
            ->where("{$name}_id", $entityId)
            ->fetch()->rating;
    }

    public function getWomenRating($entityId)
    {
        $name = substr($this->tableName, 7);

        return $this->getTable()
            ->select('sum(rating) / count(*) AS `rating`')
            ->where("{$name}_id", $entityId)
            ->where('user.gender', 'Female')
            ->fetch()->rating;
    }

    public function getMenRating($entityId)
    {
        $name = substr($this->tableName, 7);

        return $this->getTable()
            ->select('sum(rating) / count(*) AS `rating`')
            ->where("{$name}_id", $entityId)
            ->where('user.gender', 'Male')
            ->fetch()->rating;
    }

    public function getUserRatingCount($userId)
    {
        return $this->getTable()->where('user_id', $userId)->count();
    }
}
