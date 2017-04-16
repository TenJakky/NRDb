<?php

namespace App\Component;

final class EntityList extends BaseDatagridComponent
{
    /** @var \App\Model\RatingModel */
    protected $ratingModel;

    /** @var  string */
    protected $type;

    /** @var  int */
    protected $seriesId;

    public function __construct(
        \App\Model\EntityModel $entityModel,
        \App\Model\RatingModel $ratingModel)
    {
        $this->model = $entityModel;
        $this->ratingModel = $ratingModel;
    }

    public function render($type = null, $param = null)
    {
        $this->type = $type ? $type : $this->presenter->type;
        $this->seriesId = $param;

        parent::render();
    }

    public function createComponentDataGrid()
    {
        parent::createComponentDataGrid();

        if ($this->type === 'season')
        {
            $this->grid->addColumn('season_number', 'Number')->enableSort('asc');
        }
        else
        {
            $this->grid->addColumn('original_title', 'Original title')->enableSort();
            if (!in_array($this->type, array('music', 'game')))
            {
                $this->grid->addColumn('english_title', 'English Title')->enableSort();
                $this->grid->addColumn('czech_title', 'Czech Title')->enableSort();
            }
        }
        $this->grid->addColumn('artist', \App\Enum\TypeToRole::LIST_ROLE[$this->type])->enableSort();
        $this->grid->addColumn('year', 'Year')->enableSort();
        $this->grid->addColumn('rating', 'Rating')->enableSort();
        $this->grid->addColumn('my_rating', 'My Rating')->enableSort();
        $this->grid->addColumn('action', 'Action');
        $this->grid->addCellsTemplate(__DIR__ . '/EntityListCellsTemplate.latte');
        $this->grid->setTemplateParameters(array(
                'ratingModel' => $this->ratingModel));
        return $this->grid;
    }

    public function getDataSource($filter, $order)
    {
        $filters = ['type' => $this->type];

        if ($this->type === 'season')
        {
            $filters['season_series_id'] = $this->seriesId;
        }

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
                $orders = ":jun_artist2entity.artist.surname $order[1], :jun_artist2entity.artist.name $order[1]";

                if (in_array($this->type, array('music', 'game')))
                {
                    $orders = ":jun_artist2entity.artist.name $order[1], ".$orders;
                }
            }
            else if ($order[0] == 'my_rating')
            {
                $set->joinWhere(":rating", ":rating.user_id", $this->presenter->getUser()->getId());
                $orders = ":rating.value $order[1]";
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
