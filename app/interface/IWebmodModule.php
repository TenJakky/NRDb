<?php

namespace App;

interface IWebmodModule
{
    public static function getMenu() : array;

    public static function getJunction() : array;

    public static function getName() : string;
}
