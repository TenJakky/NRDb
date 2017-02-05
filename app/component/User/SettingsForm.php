<?php

namespace App\Component;

final class SettingsForm extends BaseComponent
{
    protected $userModel;
    protected $countryModel;

    public function __construct(\App\Model\Authenticator $userModel, \App\Model\CountryModel $countryModel)
    {
        $this->userModel = $userModel;
        $this->countryModel = $countryModel;
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();
        $form->addProtection('Security token has expired, please submit the form again');

        $form->addHidden('id');

        $pswd1 = $form->addPassword('password1', 'New password');
        $pswd2 = $form->addPassword('password2', 'Password again');
        $pswd2->addConditionOn($pswd1, \Nette\Forms\Form::FILLED)->setRequired();

        $form->addText('name', 'Name');
        $form->addText('surname', 'Surname');
        $form->addRadioList('gender', 'Gender', array('Male'=>'Male', 'Female'=>'Female'));
        $form->addSelect('country_id', 'Nationality', $this->countryModel->getTable()->fetchPairs('id', 'name'));
        $form->addTextArea('description', 'Description');
        $form->addText('per_page', 'Number of items per page');
        $form->addText('per_page_small', 'Number of items in small lists');

        $form->addSubmit('submit', 'Submit');

        $form->setDefaults($this->userModel->findRow($this->presenter->getUser()->getId()));
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();

        if ($values['password1'])
        {
            if ($values['password1'] != $values['password2'])
            {
                $this->presenter->flashMessage('Passwords must match.', 'failure');
                $this->presenter->redirect('Default:settings');
            }
            $values['password'] = \Nette\Security\Passwords::hash($values['password1']);
        }

        unset($values['password1']);
        unset($values['password2']);

        $this->userModel->save($values);

        $this->presenter->getUser()->getIdentity()->per_page = $values['per_page'];
        $this->presenter->getUser()->getIdentity()->per_page_small = $values['per_page_small'];

        $this->presenter->flashMessage('Settings were successfully saved.', 'success');
        $this->presenter->redirect('User:view', $values['id']);
    }
}
