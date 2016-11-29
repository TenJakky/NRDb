<?php

namespace App\Latte;

class DirectorFilter extends \Nette\Object
{
    protected $directorModel;

    public function __construct(\App\Model\DirectorModel $directorModel)
    {
        $this->directorModel = $directorModel;
    }

    public function __invoke($id)
    {
        $row = $this->directorModel->findRow($id);
        return $row->name.' '.$row->surname;
    }
}