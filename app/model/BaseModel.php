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
    public function findBy($row, $value)
    {
        return $this->getTable()->where($row, $value);
    }

    /**
     * @return \Nette\Database\Table\ActiveRow
     */
    public function findRow($rowId)
    {
        return $this->getTable()->where('id', (int) $rowId)->fetch();
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
     * @return \Nette\Database\Table\ActiveRow
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
     * @return int
     */
    public function save($data)
    {
        if (isset($data['id']) && $data['id'])
        {
            $data['id'] = (int) $data['id'];
            $this->getTable()->wherePrimary($data['id'])->update($data);
            return $data['id'];
        }
        unset($data['id']);
        $row = $this->insert($data);
        return $row->id;
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