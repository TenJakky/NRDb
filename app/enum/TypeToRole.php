<?php

namespace App\Enum;

class TypeToRole
{
	const ACTOR = 'actor';
    const DIRECTOR = 'director';
    const AUTHOR = 'author';
    const INTERPRET = 'interpret';
    const DEVELOPER = 'developer';

    const MOVIE = 'movie';
    const SERIES = 'series';
    const SEASON = 'season';
    const BOOK = 'book';
    const MUSIC = 'music';
    const GAME = 'game';

    const ROLES = [
        self::MOVIE => [self::ACTOR, self::DIRECTOR],
        self::SERIES => [self::ACTOR, self::DIRECTOR],
        self::SEASON => [self::ACTOR, self::DIRECTOR],
        self::BOOK => [self::AUTHOR],
        self::MUSIC => [self::INTERPRET],
        self::GAME => [self::DEVELOPER]
    ];
}
