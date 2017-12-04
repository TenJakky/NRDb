<?php

namespace App\Component;

abstract class BaseDatagridComponent extends \Peldax\NetteInit\Component\BaseComponent
{
    /** @var \Nextras\Datagrid\Datagrid */
    protected $grid;

    /** @var \App\Model\BaseModel */
    protected $model;

    /** @var int */
    protected $perPage;

    /** @var bool */
    protected $paginationEnabled = true;

    public function attached($presenter)
    {
        $this->perPage = $presenter->getUser()->getIdentity()->per_page;
    }

    public function createComponentDataGrid()
    {
        if ($this->grid === null)
        {
            $this->grid = new \Nextras\Datagrid\Datagrid;
        }

        $this->grid->setRowPrimaryKey('id');

        $this->grid->addCellsTemplate(__DIR__ . '/TableTag.latte');
        $this->grid->addCellsTemplate(__DIR__ . '/EmptyResult.latte');

        $this->grid->setDataSourceCallback(array($this, 'dataSource'));

        if ($this->paginationEnabled)
        {
            $this->grid->addCellsTemplate(__DIR__ . '/Paginator.latte');
            $this->grid->setPagination($this->perPage, array($this, 'dataSourceCount'));
        }
    }

    /**
     * @param $filter array
     * @param $order array
     * @return \Nette\Database\Table\Selection
     */
    abstract public function getDataSource($filter, $order);

    /**
     * @param $filter array
     * @param $order array
     * @return \Nette\Database\Table\Selection
     */
    public function dataSource($filter, $order, \Nette\Utils\Paginator $paginator = null)
    {
        return $this->getDataSource($filter, $order)->limit($this->perPage, $paginator ? $paginator->getOffset() : 0);
    }

    /**
     * @param $filter array
     * @param $order array
     * @return int
     */
    public function dataSourceCount($filter, $order)
    {
        return $this->getDataSource($filter, $order)->count('*');
    }
}
