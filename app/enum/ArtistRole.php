<?php

namespace App\Enum;

class ArtistRole
{
    const ACTOR = 'actor';
    const DIRECTOR = 'director';
    const AUTHOR = 'author';
    const INTERPRET = 'interpret';
    const DEVELOPER = 'developer';

    const ITEMS = [
        self::DIRECTOR,
        self::ACTOR,
        self::AUTHOR,
        self::INTERPRET,
        self::DEVELOPER
    ];
}
