<?php

namespace App\Component;

abstract class ArtistWorks extends BaseSmallDatagridComponent
{
    /** @var \App\Model\BaseRatingModel */
    protected $ratingModel;

    /** @var int */
    protected $artistId;

    /** @var string */
    protected $entityType;

    /** @var string */
    protected $artistType;

    public function render($artistId = 0)
    {
        $this->artistId = $artistId;
        $this->template->setFile(__DIR__.'/ArtistWorks.latte');
        $this->template->render();
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        $this->grid->addColumn('original_title', 'Original title');

        if (!in_array($this->entityType, array('Music', 'Game')))
        {
            $this->grid->addColumn('english_title', 'English Title');
            $this->grid->addColumn('czech_title', 'Czech Title');
        }

        $this->grid->addColumn('year', 'Year');
        $this->grid->addColumn('rating', 'Rating');
        $this->grid->addColumn('my_rating', 'My Rating');
        $this->grid->addColumn('action', 'Action');
        $this->grid->addCellsTemplate(__DIR__ . '/ArtistWorksCellsTemplate.latte');
        $this->grid->setTemplateParameters(array(
                'userId' => $this->presenter->user->getId(),
                'ratingModel' => $this->ratingModel,
                'eType' => $this->entityType));

        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $pname = lcfirst($this->presenter->getName());

        $entity = lcfirst($this->entityType);
        $artist = $this->artistType;

        return $this->model->findBy(":jun_{$entity}2{$artist}.{$pname}_id", $this->artistId)->order('year DESC');
    }
}
