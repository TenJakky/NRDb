<?php

namespace App\Extension;

final class Menu extends \Peldax\NetteInit\Component\BaseComponent
{
    protected $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function beforeRender() : void
    {
        $this->template->items = $this->items;
    }
}
