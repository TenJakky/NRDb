<?php

namespace App\Component;

abstract class EntityForm extends BaseComponent
{
    /** @var \App\Model\CountryModel */
    protected $countryModel;

    /** @var \App\Model\PersonModel */
    protected $personModel;

    /** @var \App\Model\PseudonymModel */
    protected $pseudonymModel;

    /** @var \App\Model\BandModel */
    protected $bandModel;

    /** @var \App\Model\BaseEntityModel */
    protected $model;

    public function createComponentPersonForm()
    {
        $form = new \Nette\Application\UI\Form();

        $countries = $this->countryModel->findAll()->fetchPairs('id', 'name');

        $form->addText('name', 'Name *');
        $form->addText('surname', 'Surname *');
        $form->addSelect('country_id', 'Nationality *', $countries)
            ->setPrompt('Select nationality');
        $form->addButton('submit_person', 'Submit');

        return $form;
    }

    public function createComponentPseudonymForm()
    {
        $form = new \Nette\Application\UI\Form();

        $person = $this->personModel->fetchSelectBox();

        $form->addText('name', 'Name *');
        $form->addSelect('person_id', 'Person *', $person)
            ->setPrompt('Select person');
        $form->addButton('submit_pseudonym', 'Submit');

        return $form;
    }

    public function createComponentBandForm()
    {
        $form = new \Nette\Application\UI\Form();

        $form->addText('name', 'Name *');
        $form->addButton('submit_band', 'Submit');

        return $form;
    }

    public function handleAddPerson()
    {
        $data = $this->getPost();

        if (isset($data['name'], $data['surname'], $data['country_id']))
        {
            $this->personModel->insert($data);
        }

        $person = $this->personModel->fetchSelectBox();
        if (isset($this['form']['director']))
        {
            $this['form']['director']->setItems($person);
            $this['form']['actor']->setItems($person);
        }
        if (isset($this['form']['author']))
        {
            $this['form']['author']->setItems($person);
        }

        $this['pseudonymForm']['person_id']->setItems($person);

        $this->redrawControl('formSnippet');
        $this->redrawControl('pseudonymSnippet');
    }

    public function handleAddPseudonym()
    {
        $data = $this->getPost();

        if (isset($data['name'], $data['person_id']))
        {
            $this->pseudonymModel->insert($data);
        }

        $pseudonym = $this->pseudonymModel->fetchSelectBox();
        if (isset($this['form']['pseudonym']))
        {
            $this['form']['pseudonym']->setItems($pseudonym);
        }

        $this->redrawControl('formSnippet');
    }

    public function handleAddBand()
    {
        $data = $this->getPost();

        if (isset($data['name']))
        {
            $this->bandModel->insert($data);
        }

        $band = $this->bandModel->fetchSelectBox();
        if (isset($this['form']['band']))
        {
            $this['form']['band']->setItems($band);
        }

        $this->redrawControl('formSnippet');
    }
}
