<?php

namespace App\Component;

use Ublaboo\DataGrid\DataGrid;

final class ArtistList extends \Nepttune\Component\BaseListComponent
{
    /** @var \App\Model\EntityModel */
    protected $entityModel;

    /** @var string */
    protected $artistType;

    public function modifyList(DataGrid $grid) : DataGrid
    {
        $this->grid->addColumn('name', 'Name')->enableSort();
        $this->grid->addColumn('country_id', 'Nationality')->enableSort();
        $this->grid->addColumn('entity_count', "{$this->getPresenter()->getName()} count");
        $this->grid->addColumn('average_rating', 'Average rating');
        $this->grid->addColumn('top_entity', "Top {$name}");

        return $this->grid;
    }
}