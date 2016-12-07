<?php

namespace App\Model;

abstract class BaseEntityModel extends BaseModel
{
    /** @var  string */
    protected $ratingTableName;

    public function getRecent($limit)
    {
        return $this->findAll()->order('id DESC')->limit($limit);
    }

    public function getTop($limit)
    {
        return $this
            ->findAll()
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

        $result = $this->query(
        "SELECT
        sum(`subsum`) AS `sum`,
        count(*) AS `size`
        FROM (
        SELECT 
        (sum({$this->ratingTableName}.rating) / count(*)) AS `subsum`
        FROM {$joinTable}
        LEFT JOIN {$this->ratingTableName} ON {$this->ratingTableName}.{$this->tableName}_id = {$joinTable}.{$this->tableName}_id
        WHERE {$joinTable}.person_id = {$personId}
        GROUP BY {$this->ratingTableName}.{$this->tableName}_id
        ) AS `subquery`")->fetch();

        return $result->size ? $result->sum / $result->size : null;
    }

    public function getNotRated($userId, $limit = false)
    {
        return $this->query(
        "SELECT
        {$this->tableName}.*
        FROM {$this->tableName}
        LEFT JOIN {$this->ratingTableName} ON {$this->tableName}.id = {$this->ratingTableName}.{$this->tableName}_id AND {$this->ratingTableName}.user_id = {$userId}
        WHERE {$this->ratingTableName}.user_id IS NULL
        ORDER BY {$this->tableName}.id DESC ".
        ($limit ? "LIMIT {$limit}" : null));
    }

    public function getRated($userId, $limit = false)
    {
        return $this->query(
        "SELECT
        {$this->tableName}.*
        FROM {$this->tableName}
        LEFT JOIN {$this->ratingTableName} ON {$this->tableName}.id = {$this->ratingTableName}.{$this->tableName}_id AND {$this->ratingTableName}.user_id = {$userId}
        WHERE {$this->ratingTableName}.user_id = {$userId}
        ORDER BY {$this->tableName}.id DESC ".
        ($limit ? "LIMIT {$limit}" : null));
    }
}
