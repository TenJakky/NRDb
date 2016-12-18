<?php

namespace App\Component;

abstract class RatingList extends BaseSmallDatagridComponent
{
    /** @var int */
    protected $entityId = 0;

    public function render($entityId = 0)
    {
        $this->entityId = $entityId;
        $this->template->setFile(__DIR__.'/RatingList.latte');
        $this->template->render();
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addColumn('user_id', 'User')->enableSort();
        $this->grid->addColumn('note', 'Note')->enableSort();
        $this->grid->addColumn('rating', 'Rating')->enableSort();
        $this->grid->addColumn('date', 'Date')->enableSort(\Nextras\Datagrid\Datagrid::ORDER_DESC);

        $this->grid->addCellsTemplate(__DIR__ . '/RatingListCellsTemplate.latte');

        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $name = lcfirst($this->presenter->getName());

        return $this->model->findBy("{$name}_id", $this->entityId);
    }
}
