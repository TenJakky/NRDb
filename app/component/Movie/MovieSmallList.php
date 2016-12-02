<?php

namespace App\Component;

class MovieSmallList extends \Nette\Application\UI\Control
{
    protected $movieModel;

    public function __construct(\App\Model\MovieModel $movieModel)
    {
        $this->movieModel = $movieModel;
    }

    public function render($type)
    {
        switch ($type)
        {
            default:
            case 'new':
                $data = $this->movieModel->findAll()->order('id DESC');
            case 'top':
                $data = $this->movieModel->findAll()->order('id DESC');
            case 'notRated':
                $data = $this->movieModel->findAll()->order('id DESC');
        }

        $data->limit($this->presenter->getUser()->getIdentity()->per_page_small);

        $this->template->setFile(str_replace(".php", ".latte", $this->getReflection()->getFileName()));
        $this->template->movies = $data;
        $this->template->render();
    }
}