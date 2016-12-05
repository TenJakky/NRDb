<?php

namespace App\Component;

class MovieList extends BaseDatagridComponent
{
    protected $ratingMovieModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        parent::__construct();

        $this->model = $movieModel;
        $this->ratingMovieModel = $ratingMovieModel;
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addColumn('original_title', 'Original title')->enableSort();
        $this->grid->addColumn('english_title', 'English Title')->enableSort();
        $this->grid->addColumn('czech_title', 'Czech Title')->enableSort();
        $this->grid->addColumn('director', 'Director')->enableSort();
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('rating', 'Rating');
        $this->grid->addColumn('men_rating', 'Men\'s Rating');
        $this->grid->addColumn('women_rating', 'Women\'s Rating');
        $this->grid->addColumn('my_rating', 'My Rating')->enableSort();

        $this->grid->addCellsTemplate(__DIR__ . '/MovieListCellsTemplate.latte');
        $this->grid->setTemplateParams(
            array(
                'userId' => $this->presenter->user->getId(),
                'ratingMovieModel' => $this->ratingMovieModel));

        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $filters = array();
        foreach ($filter as $k => $v)
        {
            if ($k == 'id' || is_array($v))
            {
                $filters[$k] = $v;
            }
            else if ($k == 'director')
            {
                $filters['person.name LIKE ?'] = "%$v%";
                $filters['person.surname LIKE ?'] = "%$v%";
            }
            else
            {
                $filters[$k . ' LIKE ?'] = "%$v%";
            }
        }

        $set = $this->model->findByArray($filters);

        if ($order[0])
        {
            if ($order[0] == 'director')
            {
                $orders = "person.surname $order[1], person.name $order[1]";
            }
            else if ($order[0] == 'rating')
            {
                //$orders = "sum(rating_sum / rating_size) $order[1]";
            }
            else if ($order[0] == 'my_rating')
            {
                $set->where(':rating_movie.user_id = '.$this->presenter->getUser()->getId());
                $orders = ":rating_movie.rating $order[1]";
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