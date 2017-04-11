<?php

namespace App\Component;

final class RatingList extends BaseSmallDatagridComponent
{
    /** @var int */
    protected $entityId = 0;

    public function __construct(
        \App\Model\RatingModel $ratingMovieModel)
    {
        parent::__construct();
        $this->model = $ratingMovieModel;
    }

    public function render($entityId = 0)
    {
        $this->entityId = $entityId;
        $this->template->setFile(__DIR__ . '/RatingList.latte');
        $this->template->render();
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addColumn('user_id', 'User')->enableSort();
        $this->grid->addColumn('value', 'Value')->enableSort();
        $this->grid->addColumn('note', 'Note');
        $this->grid->addColumn('date', 'Date')->enableSort(\Nextras\Datagrid\Datagrid::ORDER_DESC);

        $this->grid->addCellsTemplate(__DIR__ . '/RatingListCellsTemplate.latte');

        $this->grid->addTemplateParameter('userId', $this->presenter->getUser()->getId());

        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $name = lcfirst($this->presenter->getName());

        return $this->model->findBy("{$name}_id", $this->entityId);
    }
}
