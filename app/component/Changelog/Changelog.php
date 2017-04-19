<?php

namespace App\Component;

final class Changelog extends BaseRenderComponent
{
    protected $changelogModel;

    public function __construct(
        \App\Model\ChangelogModel $changelogModel)
    {
        $this->changelogModel = $changelogModel;
    }

    public function beforeRender()
    {
        $this->template->changes = $this->changelogModel->getTable()->order('date DESC')->limit(5);
    }
}
