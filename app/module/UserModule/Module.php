<?php

namespace App\UserModule;

class Module implements \App\IWebmodModule
{
    const NAME = 'User';
    const ICON = 'user';

    const MENU = [
        'profile' => [
            'name' => 'Profile',
            'icon' => 'user',
            'dest' => ':User:Profile:default'
        ]
    ];

    const JUNCTION = [
        'icon' => self::ICON,
        'dest' => ':User:Default:default'
    ];

    public static function getMenu() : array
    {
        return self::MENU;
    }

    public static function getJunction() : array
    {
        return self::JUNCTION;
    }

    public static function getName() : string
    {
        return self::NAME;
    }
}
