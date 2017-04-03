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

        $this->template->movieMax = $this->userModel->getTable()->order('ratings_movie DESC')->limit(1)->fetch()->ratings_movie;
        $this->template->seriesMax = $this->userModel->getTable()->order('ratings_series DESC')->limit(1)->fetch()->ratings_series;
        $this->template->seasonMax = $this->userModel->getTable()->order('ratings_season DESC')->limit(1)->fetch()->ratings_season;
        $this->template->bookMax = $this->userModel->getTable()->order('ratings_book DESC')->limit(1)->fetch()->ratings_book;
        $this->template->musicMax = $this->userModel->getTable()->order('ratings_music DESC')->limit(1)->fetch()->ratings_music;
        $this->template->gameMax = $this->userModel->getTable()->order('ratings_game DESC')->limit(1)->fetch()->ratings_game;

		parent::render();
	}
}
