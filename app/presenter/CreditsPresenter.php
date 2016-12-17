<?php

namespace App\Presenter;

final class CreditsPresenter extends BasePresenter
{
	protected $changelogModel;

	public function __construct(
        \App\Model\ChangelogModel $changelogModel)
	{
        $this->changelogModel = $changelogModel;
	}

	public function renderDefault()
	{
        $this->template->changes = $this->changelogModel->getTable()->order('date DESC')->limit(5);
	}
}