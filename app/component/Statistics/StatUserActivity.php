<?php

namespace App\Component;

class StatUserActivity extends BaseComponent
{
    /** @var \App\Model\UserModel */
	protected $userModel;

	public function __construct(
		\App\Model\UserModel $userModel)
	{
		$this->userModel = $userModel;
	}

	public function render()
	{
		$this->template->activeUsers = $this->userModel->getActivity();

		parent::render();
	}
}
