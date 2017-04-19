<?php

namespace App\Component;

use Tracy\Debugger;

final class EntityList extends BaseDatagridComponent
{
    /** @var \App\Model\RatingModel */
    protected $ratingModel;

    /** @var string */
    protected $type;

    public function __construct(
        \App\Model\EntityModel $entityModel,
        \App\Model\RatingModel $ratingModel)
    {
        $this->model = $entityModel;
        $this->ratingModel = $ratingModel;
    }

    public function attached($presenter)
    {
        $this->type =
            $presenter->getName() === 'Entity' &&
            $presenter->getAction() === 'view' &&
            $presenter->type === 'series' ?
            'season' : $presenter->type;

        parent::attached($presenter);
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        if ($this->type === 'season')
        {
            $this->grid->addColumn('season_number', 'Number')->enableSort('asc');
        }
        else
        {
            $this->grid->addColumn('original_title', 'Original title')->enableSort();
            if (!in_array($this->type, array('music', 'game')))
            {
                $this->grid->addColumn('english_title', 'English Title')->enableSort();
                $this->grid->addColumn('czech_title', 'Czech Title')->enableSort();
            }
        }
        $this->grid->addColumn('artist', $this->presenter->locale['role'][\App\Enum\TypeToRole::LIST_ROLE[$this->type]]);
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('rating', 'Rating')->enableSort();
        $this->grid->addColumn('my_rating', 'My Rating')->enableSort();
        $this->grid->addColumn('action', 'Action');
        $this->grid->addCellsTemplate(__DIR__ . '/EntityListCellsTemplate.latte');
        $this->grid->setTemplateParameters(array(
                'ratingModel' => $this->ratingModel));
        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $set = $this->model->getTable();
        $set->alias(':rating', 'r');
        $set->select('entity.*, r.value AS my_rating, r.id AS my_rating_id');
        $set->joinWhere('r', 'r.user_id', $this->presenter->getUser()->getId());

        $set->where('type', $this->type);

        if ($this->type === 'season')
        {
            $set->where('season_series_id', $this->presenter->getParameter('id'));
        }

        if ($order[0])
        {
            $set->order(implode(' ', $order));
        }

        return $set;
    }
}
