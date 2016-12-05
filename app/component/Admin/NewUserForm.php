<?php

namespace App\Component;

class NewUserForm extends BaseComponent
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

        $form->addText('username', 'Username')->setRequired();
        $form->addText('password', 'Password')->setRequired();

        $form->addText('name', 'Name')->setRequired();
        $form->addText('surname', 'Surname')->setRequired();

        $form->addSelect('country_id', 'Nationality', $this->countryModel->findAll()->fetchPairs('id', 'name'));

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $values['password'] = \Nette\Security\Passwords::hash($values['password']);
        $this->userModel->insert($values);
        $this->presenter->flashMessage('Successfully registered new user.', 'success');
        $this->presenter->redirect('Default:newUser');
    }
}