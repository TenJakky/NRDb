<?php

namespace App\Model;

abstract class BaseEntityModel extends BaseModel
{
    public function getRecent($limit)
    {
        return $this->findAll()->order('id DESC')->limit($limit);
    }

    public function getTop($limit)
    {
        return $this->query(
        "SELECT
        {$this->tableName}.*
        FROM {$this->tableName}
        LEFT JOIN rating_{$this->tableName} ON {$this->tableName}.id = rating_{$this->tableName}.{$this->tableName}_id
        GROUP BY {$this->tableName}.id
        ORDER BY sum(rating_{$this->tableName}.rating)/count(*) DESC
        LIMIT {$limit}")->fetchAll();
    }

    public function getNotRated($userId, $limit)
    {
        return $this->query(
        "SELECT
        {$this->tableName}.*
        FROM {$this->tableName}
        LEFT JOIN rating_{$this->tableName} ON {$this->tableName}.id = rating_{$this->tableName}.{$this->tableName}_id AND rating_{$this->tableName}.user_id = {$userId}
        WHERE rating_{$this->tableName}.user_id IS NULL
        ORDER BY {$this->tableName}.id DESC
        LIMIT {$limit}")->fetchAll();
    }
}
