<?php 

namespace marcosraudkett\Tallink\Enums;

enum Locale: string
{
    case EN    = 'en';
    case FI    = 'fi';
    case ET    = 'et';

    public const ENGLISH = self::EN->value;
    public const FINNISH = self::FI->value;
    public const ESTONIAN = self::ET->value;
}