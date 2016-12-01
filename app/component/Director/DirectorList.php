<?php

namespace App\Component;

class DirectorList extends BaseGridComponent
{
    protected $movieModel;

    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\MovieModel $movieModel
    )
    {
        parent::__construct();

        $this->model = $personModel;
        $this->movieModel = $movieModel;
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addCellsTemplate(__DIR__.'/CellsTemplate.latte');
        $this->grid->addColumn('name', 'Name')->enableSort();
        $this->grid->addColumn('country_id', 'Nationality')->enableSort();
        $this->grid->addColumn('movie_count', '# of movies');//TODO:->enableSort();
        $this->grid->addColumn('average_rating', 'Average rating');//TODO:->enableSort();
        $this->grid->addColumn('top_movie', 'Top movie');

        $this->grid->setTemplateParams(array('movieModel' => $this->movieModel));

        return $this->grid;
    }


    public function prepareDataSource($filter, $order)
    {
        $filters = array();
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
                $filters[$k . ' LIKE ?'] = "%$v%";
            }
        }

        $set = $this->model->findByArray($filters);

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