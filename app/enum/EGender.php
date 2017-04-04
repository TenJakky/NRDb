<?php

namespace App\Enum;

class EGender
{
    const MAN = 'man';
    const WOMAN = 'woman';

    const ITEMS = [
        self::MAN => 'Man',
        self::WOMAN => 'Woman'
    ];

    const ITEMS_CZE = [
        self::MAN => 'Muž',
        self::WOMAN => 'Žena'
    ];
}
