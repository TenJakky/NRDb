<?php

namespace App\Component;

final class ArtistWorks extends BaseSmallDatagridComponent
{
    /** @var \App\Model\RatingModel */
    protected $ratingModel;

    public function __construct(\App\Model\ArtistEntityModel $artistEntityModel, \App\Model\RatingModel $ratingModel)
    {
        $this->model = $artistEntityModel;
        $this->ratingModel = $ratingModel;
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addColumn('type', 'Type')->enableSort();
        $this->grid->addColumn('role', 'Role')->enableSort();
        $this->grid->addColumn('original_title', 'Original title')->enableSort();
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('rating', 'Rating')->enableSort();
        $this->grid->addColumn('my_rating', 'My Rating')->enableSort();
        $this->grid->addColumn('action', 'Action');
        $this->grid->addCellsTemplate(__DIR__ . '/ArtistWorksCellsTemplate.latte');
        $this->grid->setTemplateParameters(array(
                'ratingModel' => $this->ratingModel));
        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $set = $this->model->getTable()
            ->alias('entity:rating', 'r')
            ->select('jun_artist2entity.*, entity.*, r.value AS my_rating, r.id AS my_rating_id')
            ->joinWhere('r', 'r.user_id', $this->presenter->getUser()->getId())
            ->where('artist_id', $this->presenter->getParameter('id'));

        if ($order[0])
        {
            $set->order(implode(' ', $order));
        }

        return $set;
    }
}
