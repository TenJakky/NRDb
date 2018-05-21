<?php

namespace App\Component;

final class Changelog extends \Nepttune\Component\BaseComponent
{
    protected $changelogModel;

    public function __construct(
        \App\Model\ChangelogModel $changelogModel)
    {
        $this->changelogModel = $changelogModel;
    }

    public function beforeRender() : void
    {
        $this->template->changes = $this->changelogModel->getTable()->order('date DESC')->limit(5);
    }
}
