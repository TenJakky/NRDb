<?php

namespace App\Component;

class BaseDatagridComponent extends \Nette\Application\UI\Control
{
    /**
     * @var \App\Tool\Datagrid
     */
    protected $grid;
    /**
     * @var \App\Model\BaseModel
     */
    protected $model;

    public function createComponentDataGrid()
    {
        if ($this->grid === null)
        {
            $this->grid = new \App\Tool\Datagrid;
        }
        $this->grid->addCellsTemplate(__DIR__.'/Paginator.latte');
        $this->grid->setDatasourceCallback(array($this, 'dataSource'));
        $this->grid->setPagination($this->presenter->getUser()->getIdentity()->per_page, array($this, 'dataSourceCount'));
    }

    public function render()
    {
        $this->template->setFile(str_replace(".php", ".latte", $this->getReflection()->getFileName()));
        $this->template->render();
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
