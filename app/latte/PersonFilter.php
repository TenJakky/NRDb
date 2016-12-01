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
        $row = $this->personModel->findRow($id);
        return $row->name.' '.$row->surname;
    }
}