<?php

namespace App\Component;

class ActedList extends DirectedList
{
    public function getDataSource($filter, $order)
    {
        return $this->model->findBy(':movie2actor.person_id', $this->personId)->order('year DESC');
    }
}