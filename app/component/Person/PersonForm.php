<?php

namespace App\Component;

class PersonForm extends BaseFormComponent
{
    protected $personModel;
    protected $moviesModel;
    protected $countryModel;
    protected $ratingsMovieModel;

    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\CountryModel $countryModel)
    {
        $this->personModel = $personModel;
        $this->countryModel = $countryModel;
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->personModel->findRow($id);

            if (!$row)
            {
                $this->flashMessage('Person not found', 'failure');
                $this->redirect('Person:default');
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
        $form->addText('name', 'Person name')
            ->setRequired();
        $form->addText('surname', 'Person surname')
            ->setRequired();
        $form->addSelect('country_id', 'Person nationality', $countries)
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

        $id = $this->personModel->save($data);

        $this->flashMessage('Person successfully saved.', 'success');
        $this->presenter->redirect('Person:view', array('id' => $id));
    }
}