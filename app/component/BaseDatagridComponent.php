<?php

namespace App\Component;

class BaseDatagridComponent extends BaseComponent
{
    /**
     * @var \App\Tool\Datagrid
     */
    protected $grid;

    /**
     * @var \App\Model\BaseModel
     */
    protected $model;

    /**
     * @var int
     */
    protected $perPage;

    public function attached($presenter)
    {
        $this->perPage = $presenter->getUser()->getIdentity()->per_page;
    }

    public function createComponentDataGrid()
    {
        if ($this->grid === null)
        {
            $this->grid = new \App\Tool\Datagrid;
        }
        $this->grid->addCellsTemplate(__DIR__.'/Paginator.latte');
        $this->grid->addCellsTemplate(__DIR__.'/TableTag.latte');
        $this->grid->setDataSourceCallback(array($this, 'dataSource'));
        $this->grid->setPagination($this->perPage, array($this, 'dataSourceCount'));
    }

    public function getDataSource($filter, $order)
    {
        $filters = array();
        foreach ($filter as $k => $v) {
            if ($k == 'id' || is_array($v))
                $filters[$k] = $v;
            else
                $filters[$k. ' LIKE ?'] = "%$v%";
        }

        $set = $this->model->findByArray($filters);
        if ($order[0])
        {
            $set->order(implode(' ', $order));
        }
        return $set;
    }

    public function dataSource($filter, $order, \Nette\Utils\Paginator $paginator = null)
    {
        return $this->getDataSource($filter, $order)->limit($paginator->getItemsPerPage(), $paginator->getOffset());
    }

    public function dataSourceCount($filter, $order)
    {
        return $this->getDataSource($filter, $order)->count('*');
    }
}
