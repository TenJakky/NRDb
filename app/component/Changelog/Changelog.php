<?php

namespace App\Component;

final class Changelog extends BaseComponent
{
    protected $changelogModel;

    public function __construct(
        \App\Model\ChangelogModel $changelogModel)
    {
        $this->changelogModel = $changelogModel;
    }

    public function render()
    {
        $this->template->changes = $this->changelogModel->getTable()->order('date DESC')->limit(5);

        parent::render();
    }
}
