<?php

namespace App\Enum;

class Locale
{
    const EN = 'en';
    const CS = 'cs';
    const DE = 'de';
    const FR = 'fr';
    const RU = 'ru';
    const ES = 'es';

    const FLAG_EN = 'gb';
    const FLAG_CS = 'cz';
    const FLAG_DE = 'de';
    const FLAG_FR = 'fr';
    const FLAG_RU = 'ru';
    const FLAG_ES = 'es';

    const ITEMS = [
        self::EN => self::FLAG_EN,
        self::CS => self::FLAG_CS
    ];
}
