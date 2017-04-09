<?php

namespace App\Component;

final class EntityForm extends BaseComponent
{
    /** @var \App\Model\EntityModel */
    protected $entityModel;

    /** @var \App\Model\ArtistModel */
    protected $artistModel;

    public function __construct(
        \App\Model\EntityModel $entityModel,
        \App\Model\ArtistModel $artistModel)
    {
        $this->entityModel = $entityModel;
        $this->artistModel = $artistModel;
    }

    public function createComponent($name, array $args = null)
    {
        if ($name !== 'form')
        {
            $form = parent::createComponent($name, $args);

            $form['form']->getElementPrototype()->addClass('ajax');
            $form['form']->onSuccess[] = [$this, 'redrawSnippets'];
        }

        $form = new \Nette\Application\UI\Form;

        return $form;
    }

    public function redrawSnippets()
    {
        $this->redrawControl('formSnippet');
        $this->redrawControl('artistSnippet');
    }
}
