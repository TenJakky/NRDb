<?php

namespace App\Tool;

class Datagrid extends \Nextras\Datagrid\Datagrid
{
    /** @var array */
    protected $templateParams = array();

    public function render()
    {
        foreach ($this->templateParams as $k => $v)
        {
            $this->template->{$k} = $v;
        }

        parent::render();
    }

    public function setTemplateParams(array $params)
    {
        $this->templateParams = $params;
    }

    public function addTemplateParam($key, $val)
    {
        $this->templateParams[$key] = $val;
    }
}
