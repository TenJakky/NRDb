<?php

namespace App\Component;

class LoginForm extends BaseFormComponent
{
    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $form->addText('username', 'Username');
        $form->addPassword('password', 'Password');

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();

        try
        {
            $this->presenter->user->login($values->username, $values->password);
            $this->presenter->user->setExpiration(0, TRUE);
        }
        catch (\Nette\Security\AuthenticationException $e)
        {
            return $this->presenter->flashMessage($e->getMessage());
        }

        $this->presenter->flashMessage('Successfully logged in.', 'success');

        $this->presenter->redirect('Default:default');
    }
}