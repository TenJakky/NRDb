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

        return $this->context->createService($name);
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

    public function handleRedrawControl(string $controlName)
    {
        if ($this->isAjax() && $controlName)
        {
            if (method_exists($this, 'redraw'.ucfirst($controlName)))
            {
                $this->{'redraw'.ucfirst($controlName)}();
            }

            $this->redrawControl($controlName);
        }
    }

    public function handleRedrawRow(string $controlName, int $rowId)
    {
        if ($this->isAjax() && $controlName && $rowId)
        {
            $this[$controlName]['dataGrid']->redrawRow($rowId);
        }
    }

    public function actionCloseFancy($control = null, $rowId = null)
    {
        $this->getFlashSession()->setExpiration(time() + 5);

        $this->template->setFile(__DIR__.'/closeFancy.latte');

        $this->template->redrawControl = false;
        $this->template->redrawRow = false;

        if ($control && $rowId)
        {
            $this->template->redrawRow = true;
            $this->template->control = $control;
            $this->template->rowId = $rowId;
        }
        elseif ($control)
        {
            $this->template->redrawControl = true;
            $this->template->control = $control;
        }
    }
}
