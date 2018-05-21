<?php

namespace App\Component;

use Ublaboo\DataGrid\DataGrid;

final class EntityList extends \Nepttune\Component\BaseListComponent
{
    /** @var string */
    protected $type;

    public function __construct(
        \App\Model\EntityModel $entityModel)
    {
        $this->model = $entityModel;
    }

    public function attached($presenter)
    {
        parent::attached($presenter);

        $this->type =
            $presenter->getName() === 'Entity' &&
            $presenter->getAction() === 'view' &&
            $presenter->type === 'series' ?
                'season' : $presenter->type;

        $presenter->addStyle('/scss/dist/entityList.css');
    }

    public function modifyList(DataGrid $grid) : DataGrid
    {
        if ($this->type === 'season')
        {
            $this->grid->addColumn('season_number', 'Number')->enableSort('asc');
        }
        else
        {
            $this->grid->addColumn('original_title', 'Original title')->enableSort();
            if (!in_array($this->type, array('music', 'game'), true))
            {
                $this->grid->addColumn('english_title', 'English Title')->enableSort();
                $this->grid->addColumn('czech_title', 'Czech Title')->enableSort();
            }
        }
        $this->grid->addColumn('artist', $this->getPresenter()->locale['role'][\App\Enum\TypeToRole::LIST_ROLE[$this->type]]);
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('rating', 'Rating')->enableSort();
        $this->grid->addColumn('my_rating', 'My Rating')->enableSort();
        $this->grid->addColumn('action', 'Action');

        return $this->grid;
    }
}
