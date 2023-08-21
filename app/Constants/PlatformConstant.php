<?php

namespace App\Constants;

class PlatformConstant
{
    const ID_OF_CONSOLE = 1;
    const NAME_OF_CONSOLE = 'console';
    const ID_OF_ARCADE = 2;
    const NAME_OF_ARCADE = 'arcade';
    const ID_OF_PLATFORM = 3;
    const NAME_OF_PLATFORM = 'platform';
    const ID_OF_OPERATING_SYSTEM = 4;
    const NAME_OF_OPERATING_SYSTEM = 'operating_system';
    const ID_OF_PORTABLE_CONSOLE = 5;
    const NAME_OF_PORTABLE_CONSOLE = 'portable_console';
    const ID_OF_COMPUTER = 6;
    const NAME_OF_COMPUTER = 'computer';
    const PLATFORM_CATEGORIES = [
        self::ID_OF_CONSOLE => self::NAME_OF_CONSOLE,
        self::ID_OF_ARCADE => self::NAME_OF_ARCADE,
        self::ID_OF_PLATFORM => self::NAME_OF_PLATFORM,
        self::ID_OF_OPERATING_SYSTEM => self::NAME_OF_OPERATING_SYSTEM,
        self::ID_OF_PORTABLE_CONSOLE => self::NAME_OF_PORTABLE_CONSOLE,
        self::ID_OF_COMPUTER => self::NAME_OF_COMPUTER
    ];
    const FILLABLE = [
        'id',
        'abbreviation',
        'name',
        'category',
        'generation',
        'slug',
        'source_id'
    ];
}
