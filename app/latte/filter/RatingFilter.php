<?php

namespace App\Latte;

class RatingFilter extends \Nette\Object
{
    public function __invoke(\Nette\Database\Table\ActiveRow $entity)
    {
        return number_format($entity->rating, 2)." ({$entity->rating_count}x)";
    }
}
