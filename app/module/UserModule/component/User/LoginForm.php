<?php

namespace App\Component;

final class LoginForm extends BaseRenderComponent
{
    /** @var  \App\Model\LogLoginModel */
    protected $logLoginModel;

    public function __construct(\App\Model\LogLoginModel $logLoginModel)
    {
        $this->logLoginModel = $logLoginModel;
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();
        $form->addProtection('Security token has expired, please submit the form again');

        $form->addText('username', 'Username')->setRequired();
        $form->addPassword('password', 'Password')->setRequired();

        if ($this->logLoginModel->showCaptcha($this->getPresenter()->getRemoteAddress()))
        {
            $form->addReCaptcha('captcha', NULL, 'Please prove you are not a robot.');
        }

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();

        $log = [
            'ip_address' => new \Nette\Database\SqlLiteral("INET6_ATON('{$this->getPresenter()->getRemoteAddress()}')"),
            'username' => $values->username,
            'time' => new \Nette\Database\SqlLiteral('NOW()')
        ];

        try
        {
            $this->getPresenter()->user->login($values->username, $values->password);
            $this->getPresenter()->user->setExpiration(0, TRUE);
        }
        catch (\Nette\Security\AuthenticationException $e)
        {
            $log['result'] = 'failure';
            $this->logLoginModel->insert($log);
            return $this->getPresenter()->flashMessage($e->getMessage());
        }

        $log['result'] = 'success';
        $this->logLoginModel->insert($log);

        $this->getPresenter()->flashMessage('Successfully logged in.', 'success');
        $this->getPresenter()->restoreRequest($this->getPresenter()->backlink);
        $this->getPresenter()->redirect('Default:default');
    }
}
