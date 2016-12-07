<?php

namespace App\Component;

abstract class MakerList extends BaseDatagridComponent
{
    /** @var \App\Model\BaseEntityModel */
    protected $entityModel;

    /** @var \App\Model\BaseEntityModel */
    protected $type;

    public function render()
    {
        $this->template->setFile(__DIR__.'/MakerList.latte');
        $this->template->render();
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $name = lcfirst($this->presenter->getName());

        $this->grid->addColumn('name', 'Name')->enableSort();
        $this->grid->addColumn('country_id', 'Nationality')->enableSort();
        $this->grid->addColumn('entity_count', "# of {$name}s");
        $this->grid->addColumn('average_rating', 'Average rating');
        $this->grid->addColumn('top_entity', "Top {$name}");
        $this->grid->addCellsTemplate(__DIR__ . '/MakerListCellsTemplate.latte');
        $this->grid->setTemplateParams(array(
            'entityModel' => $this->entityModel,
            'pName' => $this->presenter->getName(),
            'pname' => $name,
            'type' => $this->type));
        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $name = lcfirst($this->presenter->getName());

        $filter[":{$name}2{$this->type}.id"] = null;

        foreach ($filter as $k => $v)
        {
            if ($k == 'id' || is_array($v))
            {
                $filters[$k] = $v;
            }
            else if ($k == 'name')
            {
                $filters['name LIKE ?'] = "%$v%";
                $filters['surname LIKE ?'] = "%$v%";
            }
            else
            {
                $filters[$k.' LIKE ?'] = "%$v%";
            }
        }

        $set = $this->model->findByArray($filter);

        if ($order[0])
        {
            if ($order[0] == 'name')
            {
                $orders = "surname $order[1], name $order[1]";
            }
            else if ($order[0] == 'country_id')
            {
                $orders = "country.name $order[1]";
            }
            else if ($order[0] == 'average_rating')
            {
                $orders = "TODO $order[1]";
            }
            else if ($order[0] == 'movie_count')
            {
                $orders = "TODO $order[1]";
            }
            else if ($order[0] == 'top_movie')
            {
                $orders = "TODO $order[1]";
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