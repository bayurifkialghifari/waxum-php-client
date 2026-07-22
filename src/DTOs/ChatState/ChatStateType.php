<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\ChatState;

enum ChatStateType: string
{
    case COMPOSING = 'composing';
    case RECORDING = 'recording';
    case PAUSED = 'paused';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
