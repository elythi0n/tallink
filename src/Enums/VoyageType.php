<?php 

namespace marcosraudkett\Tallink\Enums;

enum VoyageType: string
{
    case CRU = 'CRUISE';
    case SHU = 'SHUTTLE';

    public const CRUISE = self::CRU->value;
    public const SHUTTLE = self::SHU->value;
}