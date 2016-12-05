<?php

namespace App\Presenter;

class CreditsPresenter extends BasePresenter
{
	protected $changelogModel;

	public function __construct(
        \App\Model\ChangelogModel $changelogModel)
	{
        $this->changelogModel = $changelogModel;
	}

	public function renderDefault()
	{
        $this->template->changes = $this->changelogModel->findAll()->order('date DESC')->limit(5);
	}
}