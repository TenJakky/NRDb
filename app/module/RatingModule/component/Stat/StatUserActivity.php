<?php

namespace App\Component;

final class StatUserActivity extends \Nepttune\Component\BaseComponent
{
    /** @var \App\Model\UserModel */
	protected $userModel;

    public function __construct(
        \Nepttune\Model\Authenticator $userModel)
    {
        $this->userModel = $userModel;
	}

	public function attached($presenter)
    {
        parent::attached($presenter);

        $presenter->addScript('/js/component/statUserActivity.js');
    }

    public function beforeRender() : void
	{
		$this->template->activeUsers = $this->userModel->getTable()->order('ratings_total DESC')->limit(5);
        $this->template->max = $this->userModel->getMaxRatings();
	}
}
