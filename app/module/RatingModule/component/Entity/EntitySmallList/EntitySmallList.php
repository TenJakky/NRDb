<?php

namespace App\Component;

abstract class EntitySmallList extends BaseSmallDatagridComponent
{
    /** @var bool */
    protected $paginationEnabled = false;

    public function __construct(
        \App\Model\EntityModel $entityModel)
    {
        $this->model = $entityModel;
    }

    public function attached($presenter)
    {
        parent::attached($presenter);

        $presenter->addStyle('/scss/dist/entitySmallList.css');
    }

    public function createComponentDataGrid()
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
        $this->grid->addCellsTemplate(__DIR__.'/../@cells.latte');

        return $this->grid;
    }

    public function render() : void
    {
        $this->template->setFile(__DIR__.'/EntitySmallList.latte');
        $this->template->render();
    }
}
