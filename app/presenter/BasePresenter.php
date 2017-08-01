<?php

namespace App\Presenter;

abstract class BasePresenter extends \Nette\Application\UI\Presenter
{
    /** @persistent */
    public $lang;

    /** @var  array */
    public $locale;

    /** @var  array */
    protected $styles = [];

    /** @var  array */
    protected $scripts = [
        '/bower/jquery/dist/jquery.min.js',
        '/bower/nette.ajax.js/nette.ajax.js',
        '/vendor/nette/forms/src/assets/netteForms.min.js',
        '/vendor/peldax/datagrid/js/nextras.datagrid.js',
        '/vendor/uestla/recaptcha-control/src/assets/recaptcha.js',
        '/bower/selectize/dist/js/standalone/selectize.min.js',
        '/bower/iCheck/icheck.min.js',
        '/bower/magnific-popup/dist/jquery.magnific-popup.min.js',
        '/bower/chart.js/dist/Chart.min.js',
        '/js/dist/selectizePlugins.min.js',
        '/js/dist/coreValidator.min.js',
        '/js/dist/common.min.js'
    ];

    public function addStyle(string $path) : void
    {
        if (!in_array($path, $this->styles, true))
        {
            $this->styles[] = $path;
        }
    }

    public function addScript(string $path) : void
    {
        if (!in_array($path, $this->scripts, true))
        {
            $this->scripts[] = $path;
        }
    }

    public function getStyles() : array
    {
        return $this->styles;
    }

    public function getScripts() : array
    {
        return $this->scripts;
    }

    public static function generateChecksum(string $path)
    {
        return 'sha256-' . base64_encode(hash_file('sha256', $path, true));
    }

    public function startup() : void
    {
        parent::startup();

        switch ((string) $this->lang)
        {
            default:
                $this->lang = 'en';
            case 'en':
            case 'cs':
            case 'de':
            case 'es':
            case 'fr':
            case 'ru':
                $this->locale = require getcwd() . "/app/locale/{$this->lang}.php";
                break;
        }
    }

    public function flashMessage($message, $type = 'info') : \stdClass
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

        if ($args !== null)
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

    public function getId() : int
    {
        return (int) $this->getParameter('id');
    }

    public function handleRedrawControl(string $control = null) : void
    {
        if ($control && $this->isAjax())
        {
            if (method_exists($this, 'redraw'.ucfirst($control)))
            {
                $this->{'redraw'.ucfirst($control)}();
            }

            $this->redrawControl($control);
        }
    }

    public function handleRedrawRow(string $control = null, int $rowId = null) : void
    {
        if ($this->isAjax() && $control && $rowId)
        {
            /** @var \Nextras\Datagrid\Datagrid $grid */
            $grid = $this[$control]['dataGrid'];

            $grid->redrawRow($rowId);
        }
    }

    public function actionCloseFancy($control = null, $rowId = null) : void
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

    public function findLayoutTemplateFile() : string
    {
        $dir = dirname(self::getReflection()->getFileName());
        $primary = $dir . '/../templates/@layout.latte';

        if (is_file($primary))
        {
            return $primary;
        }

        return __DIR__ . '/../templates/@layout.latte';
    }
}
