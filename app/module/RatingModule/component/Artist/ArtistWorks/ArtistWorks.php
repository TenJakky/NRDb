<?php

namespace App\Component;

use Ublaboo\DataGrid\DataGrid;

final class ArtistWorks extends \Nepttune\Component\BaseListComponent
{
    /** @var \App\Model\RatingModel */
    protected $ratingModel;

    public function __construct(\App\Model\ArtistEntityModel $artistEntityModel, \App\Model\RatingModel $ratingModel)
    {
        $this->model = $artistEntityModel;
        $this->ratingModel = $ratingModel;
    }

    public function modifyList(DataGrid $grid) : DataGrid
    {
        $this->grid->addColumn('type', 'Type')->enableSort();
        $this->grid->addColumn('role', 'Role')->enableSort();
        $this->grid->addColumn('original_title', 'Original title')->enableSort();
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('rating', 'Rating')->enableSort();
        $this->grid->addColumn('my_rating', 'My Rating')->enableSort();
        $this->grid->addColumn('action', 'Action');

        return $grid;
    }
}
