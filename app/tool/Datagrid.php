<?php

namespace App\Tool;

class Datagrid extends \Nextras\Datagrid\Datagrid
{
    /** @var array */
    protected $templateParams = array();

    public function render()
    {
        foreach ($this->templateParams as $k => $param)
        {
            $this->template->{$k} = $param;
        }

        parent::render();
    }

    public function setTemplateParams(array $params)
    {
        $this->templateParams = $params;
    }
}