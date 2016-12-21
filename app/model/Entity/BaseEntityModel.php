<?php

namespace App\Model;

abstract class BaseEntityModel extends BaseModel
{
    /** @var  string */
    protected $ratingTableName;

    public function getRecent($limit)
    {
        return $this->getTable()->order('id DESC')->limit($limit);
    }

    public function getTop($limit)
    {
        return $this
            ->getTable()
            ->group('id')
            ->order("sum(:{$this->ratingTableName}.rating)/count(*) DESC")
            ->limit($limit);
    }

    public function getPersonTop(string $personType, int $personId)
    {
        $entity = substr($this->tableName, 4);
        $joinTable = "jun_{$entity}2{$personType}";

        return $this
            ->getTable()
            ->where(":{$joinTable}.person_id", $personId)
            ->group("{$this->tableName}.id")
            ->order("sum(:{$this->ratingTableName}.rating) DESC")
            ->fetch();
    }

    public function getPersonAverage(string $personType, int $personId)
    {
        $entity = substr($this->tableName, 4);
        $joinTable = "jun_{$entity}2{$personType}";

        return $result = $this->query(
        "SELECT
        sum(`subsum`) / count(*) AS `average`
        FROM (
        SELECT 
        (sum({$this->ratingTableName}.rating) / count(*)) AS `subsum`
        FROM {$joinTable}
        LEFT JOIN {$this->ratingTableName} ON {$this->ratingTableName}.{$entity}_id = {$joinTable}.{$entity}_id
        WHERE {$joinTable}.person_id = {$personId}
        GROUP BY {$this->ratingTableName}.{$entity}_id
        ) AS `subquery`")->fetch()->average;
    }

    public function getNotRated($userId, $limit = null)
    {
        return $this
            ->getTable()
            ->joinWhere(":{$this->ratingTableName}", ":{$this->ratingTableName}.user_id", $userId)
            ->where(":{$this->ratingTableName}.user_id", null)
            ->order("{$this->tableName}.id DESC")
            ->limit($limit);
    }

    public function getRated($userId, $limit = null)
    {
        return $this
            ->getTable()
            ->joinWhere(":{$this->ratingTableName}", ":{$this->ratingTableName}.user_id", $userId)
            ->where(":{$this->ratingTableName}.user_id", $userId)
            ->order("{$this->tableName}.id DESC")
            ->limit($limit);
    }
}
