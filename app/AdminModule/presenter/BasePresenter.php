<?php

namespace App\AdminModule\Presenter;

abstract class BasePresenter extends \App\Presenter\BasePresenter
{
	public function startup()
	{
		parent::startup();

		$role = $this->getUser()->getRoles()[0];
		if ($role != \App\Enum\ERole::ADMIN && $role != \App\Enum\ERole::MOD)
		{
			$this->flashMessage('You do not have permission to access this section.');
			$this->redirect('Default:default');
		}
	}
}
