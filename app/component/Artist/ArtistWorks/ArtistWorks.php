<?php

namespace App\Component;

final class ArtistWorks extends BaseSmallDatagridComponent
{
    /** @var \App\Model\BaseRatingModel */
    protected $ratingModel;

    /** @var int */
    protected $artistId;

    public function __construct(\App\Model\ArtistEntityModel $artistEntityModel)
    {
        $this->model = $artistEntityModel;
    }

    public function render($artistId = 0)
    {
        $this->artistId = $artistId;
        $this->template->setFile(__DIR__.'/ArtistWorks.latte');
        $this->template->render();
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addColumn('type', 'Type')->enableSort();
        $this->grid->addColumn('role', 'Role')->enableSort();
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('original_title', 'Original title')->enableSort();
        $this->grid->addColumn('rating', 'Rating')->enableSort();
        $this->grid->addColumn('my_rating', 'My Rating')->enableSort();
        $this->grid->addColumn('action', 'Action');
        $this->grid->addCellsTemplate(__DIR__ . '/ArtistWorksCellsTemplate.latte');
        $this->grid->setTemplateParameters(array(
                'ratingModel' => $this->ratingModel));

        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $filter['artist_id'] = $this->artistId;

        return parent::getDataSource($filter, $order);
    }
}
