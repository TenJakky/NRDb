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
        $joinTable = "{$this->tableName}2{$personType}";

        return $this->query(
        "SELECT
        {$this->tableName}.*
        FROM {$this->tableName}
        LEFT JOIN {$this->ratingTableName} ON {$this->tableName}.id = {$this->ratingTableName}.{$this->tableName}_id
        LEFT JOIN {$joinTable} ON {$this->tableName}.id = {$joinTable}.{$this->tableName}_id
        WHERE {$joinTable}.person_id = {$personId}
        GROUP BY {$this->tableName}.id
        ORDER BY sum({$this->ratingTableName}.rating) DESC")->fetch();
    }

    public function getPersonAverage(string $personType, int $personId)
    {
        $joinTable = "{$this->tableName}2{$personType}";

        return $result = $this->query(
        "SELECT
        sum(`subsum`) / count(*) AS `average`
        FROM (
        SELECT 
        (sum({$this->ratingTableName}.rating) / count(*)) AS `subsum`
        FROM {$joinTable}
        LEFT JOIN {$this->ratingTableName} ON {$this->ratingTableName}.{$this->tableName}_id = {$joinTable}.{$this->tableName}_id
        WHERE {$joinTable}.person_id = {$personId}
        GROUP BY {$this->ratingTableName}.{$this->tableName}_id
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
