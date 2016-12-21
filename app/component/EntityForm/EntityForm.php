<?php

namespace App\Component;

abstract class EntityForm extends BaseComponent
{
    /** @var \App\Model\CountryModel */
    protected $countryModel;

    /** @var \App\Model\PersonModel */
    protected $personModel;

    /** @var \App\Model\PersonGroupModel */
    protected $personGroupModel;

    /** @var \App\Model\BaseEntityModel */
    protected $model;

    public function createComponentPersonForm()
    {
        $form = new \Nette\Application\UI\Form();
        $form->getElementPrototype()->addClass('ajax');

        $countries = $this->countryModel->getTable()->fetchPairs('id', 'name');

        $form->addText('name', 'Name *');
        $form->addText('surname', 'Surname *');
        $form->addSelect('country_id', 'Nationality *', $countries)
            ->setPrompt('Select nationality');
        $form->addSubmit('submit_person', 'Submit');

        $form->onSubmit[] = [$this, 'personFormSubmitted'];

        return $form;
    }

    public function createComponentPseudonymForm()
    {
        $form = new \Nette\Application\UI\Form();
        $form->getElementPrototype()->addClass('ajax');

        $person = $this->personModel->fetchSelectBox();

        $form->addText('name', 'Name *');
        $form->addSelect('person_id', 'Person *', $person)
            ->setPrompt('Select person');
        $form->addSubmit('submit_pseudonym', 'Submit');

        $form->onSubmit[] = [$this, 'pseudonymFormSubmitted'];

        return $form;
    }

    public function createComponentGroupForm()
    {
        $form = new \Nette\Application\UI\Form();
        $form->getElementPrototype()->addClass('ajax');

        $form->addText('name', 'Name')
            ->setRequired();
        $form->addSubmit('submit_group', 'Submit');

        $form->onSubmit[] = [$this, 'groupFormSubmitted'];

        return $form;
    }

    public function personFormSubmitted(\Nette\Forms\Form $form)
    {
        $this->personModel->insert($form->getValues());

        $person = $this->personModel->fetchSelectBox();
        $this['pseudonymForm']['person_id']->setItems($person);
        $this->redrawControl('pseudonymSnippet');

        if (isset($this['form']['director']))
        {
            $this['form']['director']->setItems($person);
            $this['form']['actor']->setItems($person);
            $this->redrawControl('formSnippet');
        }
        if (isset($this['form']['author']))
        {
            $this['form']['author']->setItems($person);
            $this->redrawControl('formSnippet');
        }

        $this->presenter->flashMessage('Successfully submitted', 'success');
        $this->presenter->redrawControl('flash');
    }

    public function pseudonymFormSubmitted(\Nette\Forms\Form $form)
    {
        $values = $form->getValues();
        $values['type'] = 'pseudonym';

        $this->personModel->insert($values);

        if (isset($this['form']['pseudonym']))
        {
            $pseudonym = $this->personModel->fetchSelectBox();
            $this['form']['pseudonym']->setItems($pseudonym);
            $this->redrawControl('formSnippet');
        }

        $this->presenter->flashMessage('Successfully submitted', 'success');
        $this->presenter->redrawControl('flash');
    }

    public function bandFormSubmitted(\Nette\Forms\Form $form)
    {
        $this->personGroupModel->insert($form->getValues());

        if (isset($this['form']['band']))
        {
            $band = $this->personGroupModel->fetchSelectBox();
            $this['form']['band']->setItems($band);
            $this->redrawControl('formSnippet');
        }

        $this->presenter->flashMessage('Successfully submitted', 'success');
        $this->presenter->redrawControl('flash');
    }

    public function injectPersonGroupModel(\App\Model\PersonGroupModel $pgModel)
    {
        $this->personGroupModel = $pgModel;
    }

    public function injectPersonModel(\App\Model\PersonModel $pModel)
    {
        $this->personModel = $pModel;
    }

    public function injectCountryModel(\App\Model\CountryModel $cModel)
    {
        $this->countryModel = $cModel;
    }
}
