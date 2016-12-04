<?php

namespace App\Component;

class DirectedList extends BaseSmallDatagridComponent
{
    protected $ratingMovieModel;

	protected $personId = 0;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        parent::__construct();

        $this->model = $movieModel;
        $this->ratingMovieModel = $ratingMovieModel;
    }

    public function render($personId = 0)
    {
    	$this->personId = $personId;

    	parent::render();
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addColumn('original_title', 'Original title');
        $this->grid->addColumn('english_title', 'English Title');
        $this->grid->addColumn('czech_title', 'Czech Title');
        $this->grid->addColumn('year', 'Year');
        $this->grid->addColumn('rating', 'Rating');
        $this->grid->addColumn('my_rating', 'My Rating');

        $this->grid->addCellsTemplate(__DIR__ . '/ListCellsTemplate.latte');
        $this->grid->setTemplateParams(
            array(
                'userId' => $this->presenter->user->getId(),
                'ratingMovieModel' => $this->ratingMovieModel));

        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        return $this->model->findBy(':movie2director.person_id', $this->personId)->order('year DESC');
    }
}