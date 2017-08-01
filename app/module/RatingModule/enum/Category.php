<?php

namespace App\Enum;

class Category
{
    const MOVIE = 'movie';
    const SERIES = 'series';
    const SEASON = 'season';
    const BOOK = 'book';
    const MUSIC = 'music';
    const GAME = 'game';

    const ITEMS = [
        self::MOVIE,
        self::SERIES,
        self::BOOK,
        self::MUSIC,
        self::GAME
    ];
}
