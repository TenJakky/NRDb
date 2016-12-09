<?php

namespace App\Component;

abstract class PersonEntityList extends BaseSmallDatagridComponent
{
    /** @var \App\Model\BaseRatingModel */
    protected $ratingModel;

    /** @var int */
    protected $personId;

    /** @var string */
    protected $pTarget;

    public function render($personId = 0)
    {
        $this->personId = $personId;
        $this->template->setFile(__DIR__.'/PersonEntityList.latte');
        $this->template->render();
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

        $this->grid->addCellsTemplate(__DIR__ . '/PersonEntityListCellsTemplate.latte');
        $this->grid->setTemplateParams(
            array(
                'userId' => $this->presenter->user->getId(),
                'ratingModel' => $this->ratingModel,
                'pName' => $this->pTarget));

        return $this->grid;
    }
}
