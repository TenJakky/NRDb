<?php

namespace App\Component;

abstract class EntityList extends BaseDatagridComponent
{
    /** @var \App\Model\BaseRatingModel */
    protected $ratingModel;

    /** @var string */
    protected $entityType;

    /** @var string */
    protected $makerType;

    public function render()
    {
        $this->template->setFile(__DIR__.'/EntityList.latte');
        $this->template->render();
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        if ($this->entityType === 'Season')
        {
            $this->grid->addColumn('number', 'Number')->enableSort('asc');
        }
        else
        {
            $this->grid->addColumn('original_title', 'Original title')->enableSort();
            if (!in_array($this->entityType, array('Music', 'Game')))
            {
                $this->grid->addColumn('english_title', 'English Title')->enableSort();
                $this->grid->addColumn('czech_title', 'Czech Title')->enableSort();
            }
        }
        $this->grid->addColumn('maker', ucfirst($this->makerType));
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('rating', 'Rating');
        $this->grid->addColumn('men_rating', 'Men\'s Rating');
        $this->grid->addColumn('women_rating', 'Women\'s Rating');
        $this->grid->addColumn('my_rating', 'My Rating');
        $this->grid->addColumn('action', 'Action');

        $this->grid->addCellsTemplate(__DIR__ . '/EntityListCellsTemplate.latte');
        $this->grid->setTemplateParameters(array(
                'userId' => $this->presenter->user->getId(),
                'ratingModel' => $this->ratingModel,
                'eType' => $this->entityType,
                'etype' => lcfirst($this->entityType),
                'mtype' => $this->makerType));
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
            else if ($k == 'maker')
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
            if ($order[0] == 'maker')
            {
                $orders = "person.surname $order[1], person.name $order[1]";
            }
            else if ($order[0] == 'rating')
            {
                $orders = "sum(rating_sum / rating_size) $order[1]";
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
