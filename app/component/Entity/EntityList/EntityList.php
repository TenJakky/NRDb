<?php

namespace App\Component;

final class EntityList extends BaseDatagridComponent
{
    /** @var \App\Model\BaseRatingModel */
    protected $ratingModel;

    public function __construct(
        \App\Model\EntityModel $entityModel,
        \App\Model\RatingModel $ratingModel)
    {
        $this->model = $entityModel;
        $this->ratingModel = $ratingModel;
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        if ($this->presenter->type === 'season')
        {
            $this->grid->addColumn('number', 'Number')->enableSort('asc');
        }
        else
        {
            $this->grid->addColumn('original_title', 'Original title')->enableSort();
            if (!in_array($this->presenter->type, array('music', 'game')))
            {
                $this->grid->addColumn('english_title', 'English Title')->enableSort();
                $this->grid->addColumn('czech_title', 'Czech Title')->enableSort();
            }
        }
        $this->grid->addColumn('artist', 'Artist')->enableSort();
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('rating', 'Rating');
        $this->grid->addColumn('my_rating', 'My Rating')->enableSort();
        $this->grid->addColumn('action', 'Action');

        $this->grid->addCellsTemplate(__DIR__ . '/EntityListCellsTemplate.latte');
        $this->grid->setTemplateParameters(array(
                'ratingModel' => $this->ratingModel));
        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $filters = array();

        foreach ($filter as $k => $v)
        {
            if ($k == 'artist')
            {
                $filters['artist.name LIKE ?'] = "%$v%";
                $filters['artist.surname LIKE ?'] = "%$v%";
            }
            else
            {
                $filters[$k . ' LIKE ?'] = "%$v%";
            }
        }

        $set = $this->model->findByArray($filters);

        if ($order[0])
        {
            if ($order[0] == 'artist')
            {
                $table = "jun_{$this->entityType}2{$this->artistType}";

                $orders = ":{$table}.artist.surname $order[1], :{$table}.artist.name $order[1]";

                if (in_array($this->entityType, array('music', 'game')))
                {
                    $orders = ":{$table}.group.name $order[1], ".$orders;
                }
            }
            else if ($order[0] == 'rating')
            {
                $orders = "SUM(:rating_{$this->entityType}.rating / COUNT(*)) $order[1]";
            }
            else if ($order[0] == 'my_rating')
            {
                $set->joinWhere(":rating_{$this->entityType}", ":rating_{$this->entityType}.user_id", $this->presenter->getUser()->getId());
                $orders = ":rating_{$this->entityType}.rating $order[1]";
            }
            else
            {
                $orders = implode(' ', $order);
            }

            $set->order($orders);
        }

        return $set;
    }
}
