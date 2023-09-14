<?php 

namespace marcosraudkett\Tallink\Enums;

enum Station: string
{
    case HEL = 'hel';
    case TAL = 'tal';
    case STO = 'sto';
    case TUR = 'tur';
    case RIG = 'rig';
    case ALA = 'ala';
    case VIS = 'vis';

    public const HELSINKI = self::HEL->value;
    public const TALLINN = self::TAL->value;
    public const STOCKHOLM = self::STO->value;
    public const TURKU = self::TUR->value;
    public const RIGA = self::RIG->value;
    public const ALAND = self::ALA->value;
    public const VISBY = self::VIS->value;
}