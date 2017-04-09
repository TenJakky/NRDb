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
		$this->template->activeUsers = $this->userModel->getTable()->order('ratings_total DESC')->limit(5);

        $this->template->movieMax = $this->userModel->getMaxRatings('movie');
        $this->template->seriesMax = $this->userModel->getMaxRatings('series');
        $this->template->seasonMax = $this->userModel->getMaxRatings('season');
        $this->template->bookMax = $this->userModel->getMaxRatings('book');
        $this->template->musicMax = $this->userModel->getMaxRatings('music');
        $this->template->gameMax = $this->userModel->getMaxRatings('game');

		parent::render();
	}
}
