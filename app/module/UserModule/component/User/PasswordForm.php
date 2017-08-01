<?php

namespace App\Component;

final class PasswordForm extends BaseRenderComponent
{
    protected $userModel;

    public function __construct(\App\Model\Authenticator $userModel)
    {
        $this->userModel = $userModel;
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();
        $form->addProtection('Security token has expired, please submit the form again.');

        $form->addPassword('old', 'Old password')
            ->setRequired();
        $form->addPassword('new1', 'New password')
            ->setRequired();
        $form->addPassword('new2', 'New password again')
            ->setRequired()
            ->addRule($form::EQUAL, 'Passwords must match.', $form['new1']);

        $form->addSubmit('submit', 'Submit');

        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();

        $user = $this->userModel->findRow($this->getPresenter()->getUser()->getId());

        if (!\Nette\Security\Passwords::verify($values['old'], $user->password))
        {
            $this->getPresenter()->flashMessage('Password is not correct.', 'error');
            $this->redirect('this');
        }

        $user->update(['password' => \Nette\Security\Passwords::hash($values['new1'])]);

        $this->getPresenter()->flashMessage('Password was successfully saved.', 'success');
        $this->getPresenter()->redirect(':User:Profile:view', $user->id);
    }
}
