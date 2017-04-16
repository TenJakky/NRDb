<?php

namespace App\Filter;

class ArtistFilter extends \Nette\Object
{
    protected $artistModel;

    public function __construct(\App\Model\ArtistModel $artistModel)
    {
        $this->artistModel = $artistModel;
    }

    public function __invoke(\Nette\Database\Table\ActiveRow $artist)
    {
        return implode(' ', array_filter([$artist->name, $artist->middlename, $artist->surname]));
    }
}
