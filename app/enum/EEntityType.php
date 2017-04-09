<?php

namespace App\Enum;

class EEntityType
{
    const MOVIE = 'movie';
    const SERIES = 'series';
    const SEASON = 'season';
    const BOOK = 'book';
    const MUSIC = 'music';
    const GAME = 'game';

    const ITEMS = [
        self::MOVIE => 'Movie',
        self::SERIES => 'Series',
        self::SEASON => 'Season',
        self::BOOK => 'Book',
        self::MUSIC => 'Music',
        self::GAME => 'Game'
    ];

    const ITEMS_CZE = [
        self::MOVIE => 'Film',
        self::SERIES => 'Seriál',
        self::SEASON => 'Sezóna',
        self::BOOK => 'Kniha',
        self::MUSIC => 'Hudba',
        self::GAME => 'Hra'
    ];
}
