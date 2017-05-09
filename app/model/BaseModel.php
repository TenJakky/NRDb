<?php

namespace App\Model;

use Nette;

abstract class BaseModel extends Nette\Object
{
    /** @var string Table name */
    public $tableName;

    /** @var Nette\Database\Context */
    protected $context;

    public function __construct(Nette\Database\Context $context)
    {
        $this->context = $context;
    }

    /**
     * @return \Nette\Database\Context
     */
    public function getConnection()
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @return \Nette\Database\Table\Selection
     */
    public function getTable()
    {
        return $this->context->table($this->tableName);
    }

    /**
     * @return \Nette\Database\Table\Selection
     */
    public function findByArray(array $filter)
    {
        return $this->getTable()->where($filter);
    }

    /**
     * @return \Nette\Database\Table\Selection
     */
    public function findBy($column, $value)
    {
        return $this->getTable()->where($column, $value);
    }

    /**
     * @return \Nette\Database\Table\ActiveRow
     */
    public function findRow(int $rowId)
    {
        return $this->getTable()->wherePrimary($rowId)->fetch();
    }

    public function query($sql, ...$params)
    {
        return $this->context->query($sql, ...$params);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->getTable()->count();
    }

    /**
     * @return \Nette\Database\Table\IRow
     */
    public function insert($data)
    {
        return $this->getTable()->insert($data);
    }

    public function delete($rowId)
    {
        return $this->findByArray([$this->getTable()->getPrimary() => (int) $rowId])->delete();
    }

    /**
     * @return \Nette\Database\Table\ActiveRow
     */
    public function save($data)
    {
        if (isset($data['id']) && $data['id'])
        {
            $data['id'] = (int) $data['id'];
            $row = $this->getTable()->wherePrimary($data['id']);
            $row->update($data);
            return $row->fetch();
        }
        unset($data['id']);
        return $this->insert($data);
    }

    public function getColumns()
    {
        $columns = $this->context->getConnection()->getSupplementalDriver()->getColumns($this->getTableName());

        $columnsResult = array();
        foreach ($columns as $column)
        {
            $columnsResult[] = $column['name'];
        }

        return $columnsResult;
    }
}
