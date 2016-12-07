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
        $result = $this->context->query(
        "SELECT
        sum(rating) AS `sum`,
        count(*) AS `size`
        FROM {$this->tableName}
        WHERE {$this->tableName}.{$name}_id = {$entityId}")->fetch();

        if ($result['size'] === 0)
        {
            return 0;
        }
        return $result['sum'] / $result['size'];
    }

    public function getWomenRating($entityId)
    {
        $name = substr($this->tableName, 7);
        $result = $this->context->query(
        "SELECT
        sum({$this->tableName}.rating) AS `sum`,
        count(*) AS `size`
        FROM {$this->tableName}
        LEFT JOIN user ON {$this->tableName}.user_id = user.id
        WHERE {$this->tableName}.{$name}_id = {$entityId} AND user.gender = 'Female'")->fetch();

        if ($result['size'] === 0)
        {
            return 0;
        }
        return $result['sum'] / $result['size'];
    }

    public function getMenRating($entityId)
    {
        $name = substr($this->tableName, 7);
        $result = $this->context->query(
        "SELECT
        sum({$this->tableName}.rating) AS `sum`,
        count(*) AS `size` FROM {$this->tableName}
        LEFT JOIN user ON {$this->tableName}.user_id = user.id 
        WHERE {$this->tableName}.{$name}_id = {$entityId} AND user.gender = 'Male'")->fetch();

        if ($result['size'] === 0)
        {
            return 0;
        }
        return $result->sum / $result['size'];
    }
}