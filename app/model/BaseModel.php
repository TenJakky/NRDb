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

    public function getConnection()
    {
        return $this->context;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getTable()
    {
        return $this->context->table($this->tableName);
    }

    public function findByArray(array $by)
    {
        return $this->getTable()->where($by);
    }

    public function findBy($row, $value)
    {
        return $this->getTable()->where($row, $value);
    }

    public function findRow($id)
    {
        return $this->getTable()->where('id', (int) $id)->fetch();
    }

    public function query($sql, ...$params)
    {
        return $this->context->query($sql, ...$params);
    }

    public function count()
    {
        return $this->getTable()->count();
    }

    public function insert($data)
    {
        return $this->getTable()->insert($data);
    }

    public function delete($id)
    {
        return $this->findByArray(array($this->getTable()->getPrimary() => (int) $id))->delete();
    }

    public function save($data)
    {
        if (isset($data['id']) && $data['id'] != 0)
        {
            $data['id'] = (int) $data['id'];

            if ($data['id'] != 0)
            {
                $this->getTable()->where('id', $data['id'])->update($data);
                return $data['id'];
            }
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