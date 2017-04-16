<?php

namespace App\Latte;

class ArtistFilter extends \Nette\Object
{
    public function __invoke(\Nette\Database\Table\ActiveRow $artist)
    {
        return implode(' ', array_filter([$artist->name, $artist->middlename, $artist->surname]));
    }
}
