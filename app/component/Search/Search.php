<?php

namespace App\Component;

class Search extends BaseComponent
{
	protected $movieModel;
	protected $seriesModel;
	protected $bookModel;
	protected $musicModel;
	protected $gameModel;
	protected $personModel;
	protected $groupModel;

	public function __construct(
		\App\Model\MovieModel $movieModel,
		\App\Model\SeriesModel $seriesModel,
		\App\Model\BookModel $bookModel,
		\App\Model\MusicModel $musicModel,
		\App\Model\GameModel $gameModel,
		\App\Model\PersonModel $personModel,
		\App\Model\GroupModel $groupModel)
	{
		$this->movieModel = $movieModel;
		$this->seriesModel = $seriesModel;
		$this->bookModel = $bookModel;
		$this->musicModel = $musicModel;
		$this->gameModel = $gameModel;
		$this->personModel = $personModel;
		$this->groupModel = $groupModel;
	}

	private $flag = false;

	private $searchMovie = array();
	private $searchSeries = array();
	private $searchBook = array();
	private $searchMusic = array();
	private $searchGame = array();
	private $searchPerson = array();
	private $searchGroup = array();

	public function render()
	{
		$this->template->flag = $this->flag;

		$this->template->searchMovie = $this->searchMovie;
		$this->template->searchSeries = $this->searchSeries;
		$this->template->searchBook = $this->searchBook;
		$this->template->searchMusic = $this->searchMusic;
		$this->template->searchGame = $this->searchGame;
		$this->template->searchPerson = $this->searchPerson;
		$this->template->searchGroup = $this->searchGroup;

		parent::render();
	}

	public function handleSearch()
	{
		$search = $this->presenter->getPost()['search'];

		if ($search)
		{
			$this->flag = true;

			$this->searchMovie = $this->movieModel->getTable()
			    ->whereOr(array(
			    	'original_title LIKE' => "%$search%",
			    	'english_title LIKE' => "%$search%",
			    	'czech_title LIKE' => "%$search%"));
		    
		    $this->searchSeries = $this->movieModel->getTable()
		    ->whereOr(array(
		    	'original_title LIKE' => "%$search%",
		    	'english_title LIKE' => "%$search%",
		    	'czech_title LIKE' => "%$search%"));
		    
		    $this->searchBook = $this->movieModel->getTable()
		    ->whereOr(array(
		    	'original_title LIKE' => "%$search%",
		    	'english_title LIKE' => "%$search%",
		    	'czech_title LIKE' => "%$search%"));
		    
		    $this->searchMusic = $this->musicModel->getTable()
		    ->whereOr(array(
		    	'original_title LIKE' => "%$search%"));
		    
		    $this->searchGame = $this->gameModel->getTable()
		    ->whereOr(array(
		    	'original_title LIKE' => "%$search%"));

		    $this->searchPerson = $this->personModel->getTable()
		    ->whereOr(array(
		    	'name LIKE' => "%$search%",
		    	'middlename LIKE' => "%$search%",
		    	'surname LIKE' => "%$search%"));
		    
		    $this->searchGroup = $this->groupModel->getTable()
		    ->whereOr(array(
		    	'name LIKE' => "%$search%"));
		}

	    $this->redrawControl('search');
	}
}