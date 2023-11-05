<?php

namespace App\Statuses;

class ReservationEvent

{
    public const BRIDE = 1;
    public const EVENT_MAKEUP = 2;
    public const HAIR_STYLE = 3;
    public const INSTALL_EYELASHES = 4;
    public const CURL_EYELASHES = 5;
    public const RAISE_EYEBROWS = 6;
    public const NAIL_AKRELEK_INSTALL = 7;
    public const NAIL_JELL_INSTALL = 8;
    public const MASSAGE = 9;
    public const SKIN_CLEANING = 10;
    public const HAIR_EXTENSIONS = 11;
    public const package_jamelah = 12;
    public const package_meled = 13;
    public const package_bela = 14;
    public const package_fermos = 15;
    public static array $statuses = [
        self::BRIDE, self::EVENT_MAKEUP, self::HAIR_STYLE,
        self::INSTALL_EYELASHES, self::CURL_EYELASHES, self::RAISE_EYEBROWS,
        self::NAIL_AKRELEK_INSTALL,   self::NAIL_JELL_INSTALL, self::MASSAGE, self::SKIN_CLEANING, self::HAIR_EXTENSIONS,
        self::package_jamelah, self::package_meled, self::package_bela, self::package_fermos
    ];
}