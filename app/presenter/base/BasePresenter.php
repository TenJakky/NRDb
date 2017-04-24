<?php

namespace App\Presenter;

use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @persistent */
    public $lang;

    /** @var  array */
    public $locale;

    public function startup()
    {
        parent::startup();

        if (!$this->user->isLoggedIn() && ($this->action != 'login' && $this->action != 'credits'))
        {
            $this->redirect('Default:login');
        }

        switch ($this->lang)
        {
            default:
                $this->lang = 'en';
                $this->locale = require getcwd().'/app/locale/en.php';
                break;
            case 'en':
            case 'cs':
            case 'de':
            case 'es':
            case 'fr':
            case 'ru':
                $this->locale = require getcwd()."/app/locale/{$this->lang}.php";
                break;
        }
    }

    public function flashMessage($message, $type = 'info')
    {
        $flash = parent::flashMessage($message, $type);

        if ($this->isAjax())
        {
            $this->redrawControl('flashMessages');
        }

        return $flash;
    }

    public function createComponent($name, array $args = null)
    {
        if (method_exists($this, 'createComponent'.ucfirst($name)))
        {
            return parent::createComponent($name);
        }
        else if ($args != null)
        {
            return $this->context->createService($name, $args);
        }
        else
        {
            return $this->context->createService($name);
        }
    }

    public function getPost()
    {
        return $this->getHttpRequest()->getPost();
    }

    public function getRemoteAddress()
    {
        return $this->getHttpRequest()->getRemoteAddress();
    }

    public function getId()
    {
        return $this->getParameter('id');
    }
}
