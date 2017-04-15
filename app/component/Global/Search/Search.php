<?php

namespace App\Component;

final class Search extends BaseComponent
{
    /** @var  \App\Model\EntityModel */
	protected $entityModel;

    /** @var \App\Model\ArtistModel */
    protected $artistModel;

	public function __construct(
		\App\Model\EntityModel $entityModel,
		\App\Model\ArtistModel $artistModel)
	{
		$this->entityModel = $entityModel;
		$this->artistModel = $artistModel;
	}

	private $flag = false;

	private $searchEntity = array();
	private $searchArtist = array();

	public function render()
	{
		$this->template->flag = $this->flag;

		$this->template->searchEntity = $this->searchEntity;
		$this->template->searchArtist = $this->searchArtist;

		parent::render();
	}

	public function handleSearch()
	{
		$search = $this->presenter->getParameter('search');

		if ($search)
		{
			$this->flag = true;

			$this->searchEntity = $this->entityModel->getTable()
			    ->whereOr(array(
			    	'original_title LIKE' => "%$search%",
			    	'english_title LIKE' => "%$search%",
			    	'czech_title LIKE' => "%$search%"));

		    $this->searchArtist = $this->artistModel->getTable()
                ->whereOr(array(
                    'name LIKE' => "%$search%",
                    'middlename LIKE' => "%$search%",
                    'surname LIKE' => "%$search%"));
		}

	    $this->redrawControl('search');
	}
}
