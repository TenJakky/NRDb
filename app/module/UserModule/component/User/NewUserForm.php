<?php

namespace App\Component;

final class NewUserForm extends \Nepttune\Component\BaseComponent
{
    protected $userModel;
    protected $countryModel;

    public function __construct(\Nepttune\Model\Authenticator $userModel, \App\Model\CountryModel $countryModel)
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

        $form->addSelect('country_id', 'Nationality', $this->countryModel->getTable()->fetchPairs('id', 'name'));

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $values['password'] = \Nette\Security\Passwords::hash($values['password']);
        $this->userModel->insert($values);
        $this->getPresenter()->flashMessage('Successfully registered new user.', 'success');
        $this->getPresenter()->redirect('Default:newUser');
    }
}
