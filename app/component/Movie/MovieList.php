<?php

namespace App\Component;

use Tracy\Debugger;

class MovieList extends BaseGridComponent
{
    public $ratingMovieModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel
    )
    {
        parent::__construct();

        $this->model = $movieModel;
        $this->ratingMovieModel = $ratingMovieModel;
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addCellsTemplate(__DIR__.'/CellsTemplate.latte');
        $this->grid->addColumn('original_title', 'Original title')->enableSort();
        $this->grid->addColumn('english_title', 'English Title')->enableSort();
        $this->grid->addColumn('czech_title', 'Czech Title')->enableSort();
        $this->grid->addColumn('director_id', 'Director')->enableSort();
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('rating', 'Rating')->enableSort();
        $this->grid->addColumn('men_rating', 'Men\'s Rating');
        $this->grid->addColumn('women_rating', 'Women\'s Rating');
        $this->grid->addColumn('my_rating', 'My Rating')->enableSort();

        $this->grid->setTemplateParams(
            array(
                'userId' => $this->presenter->user->getId(),
                'ratingModel' => $this->ratingMovieModel));

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
            else if ($k == 'director_id')
            {
                $filters['director.name LIKE ?'] = "%$v%";
                $filters['director.surname LIKE ?'] = "%$v%";
            }
            else
            {
                $filters[$k . ' LIKE ?'] = "%$v%";
            }
        }

        $set = $this->model->findByArray($filters);

        if ($order[0])
        {
            if ($order[0] == 'director_id')
            {
                $orders = "director.surname $order[1], director.name $order[1]";
            }
            else if ($order[0] == 'rating')
            {
                $orders = "(rating_sum / rating_size) $order[1]";
            }
            else if ($order[0] == 'my_rating')
            {
                $set->where(':ratings_movie.user_id = '.$this->presenter->getUser()->getId());
                $orders = ":ratings_movie.rating $order[1]";
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