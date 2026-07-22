<?php

namespace Bayurifkialghifari\WaxumApi\Exceptions;

use Exception;

class WaxumApiException extends Exception
{
    public function __construct(
        mixed $message = '',
        int $code = 0,
        public readonly mixed $details = null,
    ) {
        $resolvedMessage = is_string($message)
            ? $message
            : (is_array($message) ? (json_encode($message) ?: 'Waxum API Exception') : (string) $message);

        parent::__construct($resolvedMessage, $code);
    }
}
