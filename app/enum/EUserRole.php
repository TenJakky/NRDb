<?php

namespace App\Enum;

class EUserRole
{
    const ADMIN = 'administrator';
    const MOD = 'moderator';
    const USER = 'user';

    const ITEMS = [
        self::ADMIN => 'Administrator',
        self::MOD => 'Moderator',
        self::USER => 'User'
    ];

    const ITEMS_CZE= [
        self::ADMIN => 'Administrátor',
        self::MOD => 'Moderátor',
        self::USER => 'Uživatel'
    ];
}
