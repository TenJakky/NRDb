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
                ->where(
                    'MATCH(original_title, english_title, czech_title) AGAINST(?)', "%$search%");
		    
		    $this->searchSeries = $this->seriesModel->getTable()
                ->where(
                    'MATCH(original_title, english_title, czech_title) AGAINST(?)', "%$search%");
		    
		    $this->searchBook = $this->bookModel->getTable()
		        ->where(
		    	    'MATCH(original_title, english_title, czech_title) AGAINST(?)', "%$search%");
		    
		    $this->searchMusic = $this->musicModel->getTable()
                ->where(
                    'MATCH(original_title) AGAINST(?)', "%$search%");
		    
		    $this->searchGame = $this->gameModel->getTable()
                ->where(
                    'MATCH(original_title) AGAINST(?)', "%$search%");

		    $this->searchPerson = $this->personModel->getTable()
		        ->where(
                    'MATCH(name, middlename, surname) AGAINST(?)', "%$search%");
		    
		    $this->searchGroup = $this->groupModel->getTable()
                ->where(
                    'MATCH(name) AGAINST(? IN BOOLEAN MODE)', "%$search%");
		}

	    $this->redrawControl('search');
	}
}