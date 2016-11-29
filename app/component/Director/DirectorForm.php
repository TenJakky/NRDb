<?php

namespace App\Component;

use App\Model\MovieModel;
use Nette\Forms\Form;

class DirectorForm extends BaseFormComponent
{
    protected $directorModel;
    protected $moviesModel;
    protected $countryModel;
    protected $ratingsMovieModel;

    public function __construct(
        \App\Model\DirectorModel $directorModel,
        \App\Model\CountryModel $countryModel)
    {
        $this->directorModel = $directorModel;
        $this->countryModel = $countryModel;
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->directorModel->findRow($id);

            if (!$row)
            {
                $this->flashMessage('Director not found', 'failure');
                $this->redirect('Director:default');
            }
            $data = $row->toArray();

            $data['born'] = $data['born'] ? date_create($data['born'])->format('d.m.Y') : null;
            $data['died'] = $data['died'] ? date_create($data['died'])->format('d.m.Y') : null;

            $this['form']->setDefaults($data);
        }

        parent::render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $countries = $this->countryModel->findAll()->fetchPairs('id', 'name');

        $form->addHidden('id');
        $form->addText('name', 'Director name')
            ->setRequired();
        $form->addText('surname', 'Director surname')
            ->setRequired();
        $form->addSelect('country_id', 'Director nationality', $countries)
            ->setPrompt('Select nationality')
            ->setRequired();
        $form->addText('born', 'Born');
        $form->addText('died', 'Died');
        $form->addTextArea('bio', 'Bio');

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        $data['born'] = $data['born'] ? date_create($data['born'])->format('Y-m-d') : null;
        $data['died'] = $data['died'] ? date_create($data['died'])->format('Y-m-d') : null;

        $id = $this->directorModel->save($data);

        $this->flashMessage('Director successfully saved.', 'success');
        $this->presenter->redirect('Director:view', array('id' => $id));
    }
}