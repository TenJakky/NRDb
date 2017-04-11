<?php

namespace App\Enum;

class EArtistRole
{
    const ACTOR = 'actor';
    const DIRECTOR = 'director';
    const AUTHOR = 'author';
    const INTERPRET = 'interpret';
    const DEVELOPER = 'developer';

    const ITEMS = [
        self::ACTOR => 'Actor',
        self::DIRECTOR => 'Director',
        self::AUTHOR => 'Author',
        self::INTERPRET => 'Interpret',
        self::DEVELOPER => 'Developer'
    ];
}
