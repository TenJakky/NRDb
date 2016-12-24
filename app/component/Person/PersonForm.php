<?php

namespace App\Component;

final class PersonForm extends BaseComponent
{
    /** @var \App\Model\PersonModel */
    protected $personModel;

    /** @var \App\Model\CountryModel */
    protected $countryModel;

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

            $data = $row->toArray();
            $data['born'] = $data['born'] ? date_create($data['born'])->format('d.m.Y') : null;
            $data['died'] = $data['died'] ? date_create($data['died'])->format('d.m.Y') : null;

            $this['form']->setDefaults($data);
        }

        $this->template->setFile(__DIR__.'/PersonForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $countries = $this->countryModel->getTable()->fetchPairs('id', 'name');

        $form->addHidden('id');
        $form->addText('name', 'Name')
            ->setRequired();
        $form->addText('middlename', 'Middle Name');
        $form->addText('surname', 'Surname')
            ->setRequired();
        $form->addSelect('country_id', 'Nationality', $countries)
            ->setPrompt('Select nationality')
            ->setRequired();
        $form->addDatePicker('born', 'Born');
        $form->addDatePicker('died', 'Died');
        $form->addTextArea('description', 'Description');

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

        $this->presenter->flashMessage('Person successfully saved.', 'success');

        if ($this->presenter->isAjax())
        {
            $this->presenter->redrawControl('flash');
            return;
        }

        $this->presenter->redirect('Person:view', array('id' => $id));
    }
}
