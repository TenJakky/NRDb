<?php

namespace App\Component;

abstract class EntityForm extends BaseComponent
{
    /** @var \App\Model\BaseEntityModel */
    protected $model;

    /** @var \App\Model\PersonModel */
    protected $personModel;

    /** @var \App\Model\PersonGroupModel */
    protected $personGroupModel;

    public function createComponent($name, array $args = null)
    {
        if ($name === 'form')
        {
            return parent::createComponent($name, $args);
        }

        $form = parent::createComponent($name, $args);

        $form['form']->getElementPrototype()->addClass('ajax');
        $form['form']->onSuccess[] = [$this, 'redrawSnippets'];

        return $form;
    }

    public function redrawSnippets()
    {
        $this->redrawControl('formSnippet');
        $this->redrawControl('pseudonymSnippet');
        $this->redrawControl('personGroupSnippet');
    }

    public function injectPersonModel(\App\Model\PersonModel $personModel)
    {
        $this->personModel = $personModel;
    }

    public function injectPersonGroupModel(\App\Model\PersonGroupModel $personGroupModel)
    {
        $this->personGroupModel = $personGroupModel;
    }
}
