<?php

namespace App\Component;

use Ublaboo\DataGrid\DataGrid;

final class RatingList extends \Nepttune\Component\BaseListComponent
{
    /** @var int */
    protected $entityId = 0;

    public function __construct(
        \App\Model\RatingModel $ratingMovieModel)
    {
        parent::__construct();
        $this->model = $ratingMovieModel;
    }

    public function render($entityId = 0) : void
    {
        $this->entityId = $entityId;
        $this->template->setFile(__DIR__ . '/RatingList.latte');
        $this->template->render();
    }

    public function modifyList(DataGrid $grid) : DataGrid
    {
        $this->grid->addColumn('user_id', 'User')->enableSort();
        $this->grid->addColumn('value', 'Value')->enableSort();
        $this->grid->addColumn('note', 'Note');
        $this->grid->addColumn('date', 'Date')->enableSort(\Nextras\Datagrid\Datagrid::ORDER_DESC);

        return $this->grid;
    }
}
