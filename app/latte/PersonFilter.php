<?php

namespace App\Latte;

class PersonFilter extends \Nette\Object
{
    protected $personModel;

    public function __construct(\App\Model\PersonModel $personModel)
    {
        $this->personModel = $personModel;
    }

    public function __invoke($id)
    {
        return $this->personModel->getTable()->select("concat_ws(' ', name, middlename, surname) AS name")->wherePrimary($id)->fetch()->name;
    }
}
