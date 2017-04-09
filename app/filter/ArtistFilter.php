<?php

namespace App\Filter;

class ArtistFilter extends \Nette\Object
{
    protected $artistModel;

    public function __construct(\App\Model\ArtistModel $artistModel)
    {
        $this->artistModel = $artistModel;
    }

    public function __invoke($id)
    {
        return $this->artistModel->getTable()->select("concat_ws(' ', name, middlename, surname) AS name")->wherePrimary($id)->fetch()->name;
    }
}
