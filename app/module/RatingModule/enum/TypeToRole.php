<?php

namespace App\Enum;

use App\Enum\EntityType as ET;
use App\Enum\ArtistRole as AR;

class TypeToRole
{
    const ROLES = [
        ET::MOVIE => [AR::DIRECTOR, AR::ACTOR],
        ET::SERIES => [],
        ET::SEASON => [AR::DIRECTOR, AR::ACTOR],
        ET::BOOK => [AR::AUTHOR],
        ET::MUSIC => [AR::INTERPRET],
        ET::GAME => [AR::DEVELOPER]
    ];

    const LIST_ROLE = [
        ET::MOVIE => AR::DIRECTOR,
        ET::SERIES => AR::DIRECTOR,
        ET::SEASON => AR::DIRECTOR,
        ET::BOOK => AR::AUTHOR,
        ET::MUSIC => AR::INTERPRET,
        ET::GAME => AR::DEVELOPER
    ];
}
