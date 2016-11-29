<?php

namespace App\Model;

use Nette;

abstract class BaseModel extends Nette\Object
{
    /** @var string Table name */
    protected $tableName;

    /** @var Nette\Database\Context */
    protected $context;

    public function __construct(\Nette\Database\Context $context)
    {
        $this->context = $context;
    }

    protected function getTableName()
    {
        return $this->tableName;
    }

    protected function getTable()
    {
        return $this->context->table($this->tableName);
    }

    public function findAll()
    {
        return $this->getTable();
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

    public function insert($data)
    {
        return $this->getTable()->insert($data);
    }

    public function delete($id)
    {
        return $this->findByArray(array($this->getTable()->getPrimary() => (int) $id))->delete();
    }

    public function save($data, $id = 0)
    {
        $id = (int) $id;

        if (isset($data['id']))
        {
            $data['id'] = (int) $data['id'];
            $this->getTable()->where('id', $data['id'])->update($data);

            return $data['id'];
        }
        else if (0 === $id)
        {
            $row = $this->insert($data);
            return $row->id;
        }
        else
        {
            $this->getTable()->where('id', $data['id'])->update($data);
            return $id;
        }
    }

    public function getColumns()
    {
        $columns = $this->context->connection->getSupplementalDriver()->getColumns($this->getTableName());

        $columnsResult = array();

        foreach ($columns as $column)
        {
            $columnsResult[] = $column['name'];
        }

        return $columnsResult;
    }

    public function query($sql)
    {
        return $this->context->query($sql);
    }
}