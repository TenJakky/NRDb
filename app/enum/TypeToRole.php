<?php

namespace App\Enum;

use App\Enum\EEntityType as E;
use App\Enum\EArtistRole as A;

class TypeToRole
{
    const ROLES = [
        E::MOVIE => [A::ACTOR, A::DIRECTOR],
        E::SERIES => [A::ACTOR, A::DIRECTOR],
        E::SEASON => [A::ACTOR, A::DIRECTOR],
        E::BOOK => [A::AUTHOR],
        E::MUSIC => [A::INTERPRET],
        E::GAME => [A::DEVELOPER]
    ];
}
