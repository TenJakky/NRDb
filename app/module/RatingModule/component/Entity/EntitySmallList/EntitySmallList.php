<?php

namespace App\Component;

use Ublaboo\DataGrid\DataGrid;

abstract class EntitySmallList extends \Nepttune\Component\BaseListComponent
{
    /** @var bool */
    protected $paginationEnabled = false;

    public function __construct(\App\Model\EntityModel $entityModel)
    {
        $this->model = $entityModel;
    }

    public function modifyList(DataGrid $grid) : DataGrid
    {
        parent::createComponentDataGrid();

        $this->grid->addColumn('original_title', 'Original title');
        if (!in_array($this->getPresenter()->type, array('music', 'game'), true))
        {
            $this->grid->addColumn('english_title', 'English Title');
            $this->grid->addColumn('czech_title', 'Czech Title');
        }
        $this->grid->addColumn('year', 'Year');
        $this->grid->addColumn('rating', 'Rating');
        $this->grid->addColumn('my_rating', 'My Rating');
        $this->grid->addColumn('action', 'Action');

        return $grid;
    }
}
