<?php

namespace App\Component;

abstract class EntityForm extends BaseComponent
{
    /** @var \App\Model\CountryModel */
    protected $countryModel;

    /** @var \App\Model\PersonModel */
    protected $personModel;

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

    public function handleAddPerson()
    {
        if (!$this->presenter->isAjax())
        {
            return;
        }

        $data = $this->presenter->getContext()->getByType('Nette\Http\Request')->getPost();

        if (isset($data['name'], $data['surname'], $data['country_id']))
        {
            $this->personModel->insert($data);
        }

        $person = $this->personModel->fetchSelectBox();
        $this['form']['director']->setItems($person);
        $this['form']['actor']->setItems($person);

        $this->redrawControl('formSnippet');
    }
}
