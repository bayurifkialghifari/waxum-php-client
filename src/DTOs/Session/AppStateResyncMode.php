<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Session;

enum AppStateResyncMode: string
{
    case INCREMENTAL = 'incremental';
    case SNAPSHOT = 'snapshot';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
